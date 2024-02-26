<div class="pb-16 md:pb-32">
    <x-slot:title>Visualisasi</x-slot:title>
    @include('livewire.includes.offline-alert')
    <x-button-small-0 color='red' wire:click='dd'>DD</x-button-small-0>

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Visualisasi
        </h2>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Analisis Gap antara Harapan dengan Kinerja
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block  text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Pilih Survei


                </span>
                <div>
                    <div class="py-2" wire:ignore>
                        <select wire:model.live='surveyID' id="surveyID"
                            class="select2 block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="" selected>Pilih Survei</option>
                            @foreach ($surveys as $survey)
                                <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-error-display name="surveyID" />
                    <x-button-small-0 color='green' wire:click='generateChart'>Generate</x-button-small-0>
                </div>


                <div class="my-2 py-2 flex flex-col md:flex-row justify-around">
                    <div class="chart-container md:w-2/5">
                        <canvas wire:ignore id="monitoringChart"></canvas>
                    </div>
                    <div class="md:w-2/5" wire:ignore id="chartContainer">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>

                @if ($dataDeskripsi != null)
                    <div class="flex justify-center text-md">
                        <div class="min-w-0 xl:w-2/3 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                                Deskripsi
                            </h4>

                            <p class="indent-8 text-justify text-gray-600 dark:text-gray-400">
                                Survei {{ $dataDeskripsi['surveyName'] }} dilakukan pada tahun
                                {{ $dataDeskripsi['surveyYear'] }} dengan jumlah
                                responden
                                {{ $dataDeskripsi['respondenCount'] }} orang dan target jumlah responden
                                {{ $dataDeskripsi['expectedRespondents'] }} orang. Berikut
                                adalah hasil analisis gap antara harapan dengan kinerja.
                            </p>
                            <p class="indent-8 text-justify text-gray-600 dark:text-gray-400">
                                @foreach ($dataDeskripsi['dimensionData']['labels'] as $key => $labels)
                                    Untuk dimensi {{ $labels }} memiliki nilai harapan sebesar
                                    {{ $dataDeskripsi['dimensionData']['datasets'][0]['data'][$key] }}
                                    sedangkan kenyataan sebesar
                                    {{ $dataDeskripsi['dimensionData']['datasets'][1]['data'][$key] }}.
                                @endforeach
                            </p>
                            <p class="indent-8 text-justify text-gray-600 dark:text-gray-400">
                                Gap tertinggi terdapat pada dimensi {{ $dataDeskripsi['maxGap']['label'] }} dengan nilai
                                {{ $dataDeskripsi['maxGap']['value'] }}. Sedangkan gap terendah terdapat pada dimensi
                                {{ $dataDeskripsi['minGap']['label'] }} dengan nilai
                                {{ $dataDeskripsi['minGap']['value'] }}. Gap rata-rata sebesar
                                {{ $dataDeskripsi['gapKeseluruhan'] }}.
                            </p>


                        </div>
                    </div>
                @endif
            </label>
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
            const labels2 = ["Harapan", "Kenyataan"];
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
