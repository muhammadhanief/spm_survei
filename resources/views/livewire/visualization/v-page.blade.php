<div class="pb-16 md:pb-32">
    <x-slot:title>Visualisasi</x-slot:title>
    @include('livewire.includes.offline-alert')
    <x-button-small-0 color='red' wire:click='dd'>DD</x-button-small-0>

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Visualisasi
        </h2>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Elements
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block  text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Pilih Survei
                </span>
                <div class="py-2" wire:ignore>
                    <select wire:model.live='surveyID' id="surveyID"
                        class="select2 block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih Dimensi Induk</option>
                        @foreach ($surveys as $survey)
                            <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-error-display name="surveyID" />
                <x-button-small-0 color='green' wire:click='generateChart'>Generate</x-button-small-0>
            </label>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex flex-col md:flex-row justify-around ">
                <div class="chart-container w-2/5">
                    <canvas wire:ignore id="monitoringChart"></canvas>
                </div>
                <div class="w-2/5" wire:ignore id="chartContainer">
                    <canvas id="chart3"></canvas>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            {{-- untuk select2 --}}
            $(document).ready(function() {
                $('#surveyID').select2();
                $('#surveyID').on('change', function() {
                    var data = $('#surveyID').select2("val");
                    $wire.surveyID = data;
                });
            });

            // BEGINNING radar chart
            const data = {
                labels: [],
                datasets: [{
                    label: 'My First Dataset',
                }, {
                    label: 'My Second Dataset',
                }]
            };
            const config = {
                type: 'radar',
                data: data,
                options: {
                    responsive: true,
                    // maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Radar Chart',
                            font: {
                                size: 20,
                            }
                        },

                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: false
                            },
                            suggestedMin: 0,
                            suggestedMax: 4,
                        }
                    }
                }

            }
            var ctx = document.getElementById('monitoringChart'); // node
            var ctx = document.getElementById('monitoringChart').getContext('2d'); // 2d context
            // ctx.canvas.width = 700; // Sesuaikan dengan lebar yang diinginkan
            // ctx.canvas.height = 700; // Sesuaikan dengan tinggi yang diinginkan
            var radarChart = new Chart(
                ctx, config
            );
            var canvas = radarChart.canvas;
            // END of radar chart


            // BEGINING  stacKed bar chart
            const labels2 = ["Kenyataan", "Harapan"];
            const data2 = {
                labels: labels2,
                datasets: [{
                        label: 'Nilai',
                    },
                    {
                        label: 'Gap',
                    },
                ]
            };
            const config2 = {
                type: 'bar',
                data: data2,
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: 'Stacked Bar Chart'
                        },
                    },
                    responsive: true,
                    // maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            min: 0,
                            max: 4,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            };
            var ctx3 = document.getElementById('chart3').getContext('2d');
            var stackedGapChart = new Chart(ctx3, config2);
            // END of stacked bar chart

            // FOR LIVEWIRE UPDATE
            $wire.on('chartUpdated', (dataGap) => {
                dataObject = dataGap[0]['radar'];
                const datanya = dataObject;
                radarChart.data = datanya;
                radarChart.update();

                dataStackedObject = dataGap[0]['stackedBarGap'];
                const datanyaStacked = dataStackedObject;
                stackedGapChart.data.datasets[0].data = datanyaStacked[0]; // ini untuk data asli
                stackedGapChart.data.datasets[1].data = datanyaStacked[1]; // ini untuk data gap
                xScalesAxisMax = datanyaStacked[0][1] + datanyaStacked[1][1];
                stackedGapChart.options.scales.x.max = xScalesAxisMax;
                stackedGapChart.update();
            });
        </script>
    @endscript

</div>
