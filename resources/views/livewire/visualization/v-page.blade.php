<div class="pb-16 md:pb-32">
    <x-slot:title>Visualisasi</x-slot:title>
    @include('livewire.includes.offline-alert')
    {{-- <x-button-small-0 color='red' wire:click='dd'>DD</x-button-small-0> --}}

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Visualisasi
        </h2>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Analisis Gap antara Harapan dengan Kenyataan
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Pilih Survei
                </span>
                <div>
                    <div class="py-2" wire:ignore>
                        <select wire:model.live='surveyID' id="surveyID"
                            class="block w-full mt-1 text-sm text-black select2 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="" selected>Pilih Survei</option>
                            @foreach ($surveys as $survey)
                                <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-error-display name="surveyID" />
                    <x-button-small-0 class="mt-2" color='green'
                        wire:click='generateChart'>Generate</x-button-small-0>
                </div>


                <div class="flex flex-col justify-around py-2 my-2 md:flex-row">
                    <div class="chart-container md:w-2/5">
                        <canvas wire:ignore id="monitoringChart"></canvas>
                    </div>
                    <div class="md:w-2/5" wire:ignore id="chartContainer">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>
                @if ($dataDeskripsi != null)
                    <div class="flex justify-center text-md">
                        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs xl:w-2/3 dark:bg-gray-800">
                            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                                Deskripsi
                            </h4>
                            <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                Survei {{ $dataDeskripsi['surveyName'] }} dilakukan pada tahun
                                {{ $dataDeskripsi['surveyYear'] }} dengan jumlah
                                responden
                                {{ $dataDeskripsi['respondenCount'] }} orang dan target jumlah responden
                                {{ $dataDeskripsi['expectedRespondents'] }} orang. Berikut
                                adalah hasil analisis gap antara harapan dengan kinerja.
                            </p>
                            <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                @foreach ($dataDeskripsi['dimensionData']['labels'] as $key => $labels)
                                    Untuk dimensi {{ $labels }} memiliki nilai harapan sebesar
                                    {{ $dataDeskripsi['dimensionData']['datasets'][0]['data'][$key] }}
                                    sedangkan kenyataan sebesar
                                    {{ $dataDeskripsi['dimensionData']['datasets'][1]['data'][$key] }}.
                                @endforeach
                            </p>
                            <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                Gap tertinggi terdapat pada dimensi {{ $dataDeskripsi['maxGap']['label'] }} dengan nilai
                                {{ $dataDeskripsi['maxGap']['value'] }}. Sedangkan gap terendah terdapat pada dimensi
                                {{ $dataDeskripsi['minGap']['label'] }} dengan nilai
                                {{ $dataDeskripsi['minGap']['value'] }}. Gap rata-rata sebesar
                                {{ $dataDeskripsi['gapKeseluruhan'] }}.
                            </p>
                        </div>
                    </div>
                @endif
        </div>

        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Analisis Harapan dan Kepuasan pada masing-masing dimensi
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div>
                @if ($dimensionofSurvei != null)
                    <span class="text-gray-700 dark:text-gray-400">
                        Pilih dimensi
                    </span>
                    <select wire:model.live='subDimension'
                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih Dimensi</option>
                        @foreach ($subdimensions as $subdimension)
                            @if ($subdimension->dimension_id == $dimensionofSurvei->id)
                                <option value="{{ $subdimension->id }}">{{ $subdimension->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-error-display name="subDimension" />
                    <x-button-small-0 class="mt-2" color='green'
                        wire:click='generatePieChartDimension'>Generate</x-button-small-0>
                @endif
            </div>
            <div class="text-center">
                <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                    Dimensi
                    @if ($judulsubDimension != null)
                        {{ $judulsubDimension }}
                    @endif
                </h4>
            </div>

            <div class="flex flex-col justify-around py-2 my-2 md:flex-row">
                <div class="chart-container md:w-2/5">
                    <canvas wire:ignore id="pieChartHarapan"></canvas>
                </div>
                <div class="md:w-2/5" wire:ignore id="chartContainer">
                    <canvas id="pieChartKenyataan"></canvas>
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

            // START OF PIE CHART
            // pie chart harapan
            const data3 = {
                labels: [
                    'Label 1',
                    'Label 2',
                    'Label 3'
                ],
                datasets: [{
                    label: 'Jumlah Responden',
                    data: [],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            };
            const config3 = {
                type: 'doughnut',
                data: data3,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: 'Pie Chart Harapan'
                        },
                    },
                }
            };
            var ctx4 = document.getElementById('pieChartHarapan').getContext('2d');
            var pieChartHarapan = new Chart(ctx4, config3);


            // pie chart kenyataan
            const data4 = {
                labels: [
                    'Label 1',
                    'Label 2',
                    'Label 3'
                ],
                datasets: [{
                    label: 'Jumlah Responden',
                    data: [],
                    hoverOffset: 4
                }]
            };
            const config4 = {
                type: 'doughnut',
                data: data3,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: 'Pie Chart Kenyataan'
                        },
                    },
                }
            };
            var ctx5 = document.getElementById('pieChartKenyataan').getContext('2d');
            var pieChartKenyataan = new Chart(ctx5, config4);
            // END OF PIE CHART

            // FOR LIVEWIRE UPDATE
            // for analisis gap
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
            // For dimension chart
            $wire.on('chartPieUpdated', (dataPie) => {
                console.log(dataPie);
                dataHarapanObject = dataPie[0]['Harapan'];
                console.log(dataPie[0]);
                const labels = Object.keys(dataHarapanObject);
                const data = Object.values(dataHarapanObject);
                pieChartHarapan.data.labels = labels;
                pieChartHarapan.data.datasets[0].data = data;
                const generateBrighterGradientColor = (index, total) => {
                    const hue = (index / total) * 120; // Hue range from 0 to 120 for green to red
                    const saturation = 100; // Full saturation
                    const lightness = 50 + (index / total) * 25; // Adjust lightness for brightness
                    return `hsl(${hue},${saturation}%,${lightness}%)`;
                };

                const totalLabels = labels.length;
                const backgroundColors = labels.map((label, index) => generateBrighterGradientColor(index,
                    totalLabels));
                pieChartKenyataan.data.datasets[0].backgroundColor = backgroundColors;

                pieChartHarapan.update();

                dataKenyataanObject = dataPie[0]['Kenyataan'];
                const labels2 = Object.keys(dataKenyataanObject);
                const data2 = Object.values(dataKenyataanObject);
                pieChartKenyataan.data.labels = labels2;
                pieChartKenyataan.data.datasets[0].data = data2;
                pieChartKenyataan.update();


            });
        </script>
    @endscript

</div>
