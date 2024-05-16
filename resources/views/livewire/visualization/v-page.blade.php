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

                <div class="flex flex-col justify-around py-2 my-2 md:flex-row gap-y-6">
                    <div class="border-2 rounded-lg border-slate-200 chart-container md:w-2/5">
                        <canvas wire:ignore id="monitoringChart"></canvas>
                    </div>
                    <div class="border-2 rounded-lg border-slate-200 md:w-2/5 " wire:ignore id="chartContainer">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>
                <div class="flex flex-col justify-around py-2 my-2 md:px-14 md:flex-row">
                    {{-- <div class="chart-container md:w-2/5">
                        <canvas wire:ignore id="monitoringChart"></canvas>
                    </div> --}}
                    <div class="border-2 rounded-lg border-slate-200 md:w-full" wire:ignore id="quadrantsContainer">
                        <canvas id="quadrantsChart"></canvas>
                    </div>
                </div>
                @if ($dataDeskripsi != null)
                    <div class="flex justify-center text-md">
                        <div
                            class="min-w-0 p-4 bg-white border-2 rounded-lg border-slate-200 xl:w-2/3 dark:bg-gray-800">
                            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                                Deskripsi
                            </h4>
                            <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                Survei {{ $dataDeskripsi['surveyName'] }} dilakukan pada tahun
                                {{ number_format($dataDeskripsi['surveyYear'], 2, ',', '.') }} dengan jumlah
                                responden
                                {{ number_format($dataDeskripsi['respondenCount'], 2, ',', '.') }} orang dan target
                                jumlah responden
                                {{ number_format($dataDeskripsi['expectedRespondents'], 2, ',', '.') }} orang. Berikut
                                adalah hasil analisis gap antara harapan dengan kinerja.
                            </p>
                            <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                @foreach ($dataDeskripsi['dimensionData']['labels'] as $key => $labels)
                                    Untuk dimensi {{ $labels }} memiliki nilai harapan sebesar
                                    {{ number_format($dataDeskripsi['dimensionData']['datasets'][0]['data'][$key], 2, ',', '.') }}
                                    sedangkan kenyataan sebesar
                                    {{ number_format($dataDeskripsi['dimensionData']['datasets'][1]['data'][$key], 2, ',', '.') }}.
                                @endforeach
                            </p>
                            <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                Gap tertinggi terdapat pada dimensi {{ $dataDeskripsi['maxGap']['label'] }} dengan nilai
                                {{ number_format($dataDeskripsi['maxGap']['value'], 2, ',', '.') }}. Sedangkan gap
                                terendah terdapat pada dimensi
                                {{ $dataDeskripsi['minGap']['label'] }} dengan nilai
                                {{ number_format($dataDeskripsi['minGap']['value'], 2, ',', '.') }}. Gap rata-rata
                                sebesar
                                {{ number_format($dataDeskripsi['gapKeseluruhan'], 2, ',', '.') }}.
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
                $("#surveyID").select2();
                $("#surveyID").on("change", function() {
                    var data = $("#surveyID").select2("val");
                    $wire.surveyID = data;
                });
            });

            // BEGINNING radar chart
            const data = {
                labels: [],
                datasets: [{
                        label: "My First Dataset",
                    },
                    {
                        label: "My Second Dataset",
                    },
                ],
            };
            const config = {
                type: "radar",
                data: data,
                options: {
                    responsive: true,
                    // maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            text: "Diagram Radar",
                            font: {
                                size: 20,
                            },
                        },
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: false,
                            },
                            suggestedMin: 0,
                            suggestedMax: 4,
                        },
                    },
                },
            };
            var ctx = document.getElementById("monitoringChart"); // node
            var ctx = document.getElementById("monitoringChart").getContext("2d"); // 2d context
            // ctx.canvas.width = 700; // Sesuaikan dengan lebar yang diinginkan
            // ctx.canvas.height = 700; // Sesuaikan dengan tinggi yang diinginkan
            var radarChart = new Chart(ctx, config);
            var canvas = radarChart.canvas;
            // END of radar chart

            // BEGINING  stacKed bar chart
            const labels2 = ["Harapan", "Kenyataan"];
            const data2 = {
                labels: labels2,
                datasets: [{
                        label: "Nilai",
                    },
                    {
                        label: "Gap",
                    },
                ],
            };
            const config2 = {
                type: "bar",
                data: data2,
                options: {
                    indexAxis: "y",
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: ["Diagram Batang", "Harapan Kenyataan dan Gap"],
                            // fullSize: false,
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = ((value * 100) / sum).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + "%";
                                return percentage;
                            },
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
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
                            stacked: true,
                        },
                    },
                },
                plugins: [ChartDataLabels],
            };
            var ctx3 = document.getElementById("chart3").getContext("2d");
            var stackedGapChart = new Chart(ctx3, config2);
            // END of stacked bar chart

            // BEGINING QUADRANTS CHART
            const quadrantsData2 = {
                datasets: [{
                    label: "Dataset 1",
                    data: [],
                    borderColor: "red", // 'rgb(255, 99, 132)
                    backgroundColor: "red", // 'rgb(255, 99, 132)
                }, ],
            };

            let dataQuadrantsAxisXObject = 0; // Misalnya, nilai awal
            let dataQuadrantsAxisYObject = -0;

            const quadrants = {
                id: "quadrants",
                beforeDraw(chart, args, options) {
                    const {
                        ctx,
                        chartArea: {
                            left,
                            top,
                            right,
                            bottom
                        },
                        scales: {
                            x,
                            y
                        },
                    } = chart;
                    const midX = x.getPixelForValue(dataQuadrantsAxisXObject);
                    const midY = y.getPixelForValue(dataQuadrantsAxisYObject);
                    ctx.save();
                    ctx.fillStyle = options.topLeft;
                    ctx.fillRect(left, top, midX - left, midY - top);
                    ctx.fillStyle = options.topRight;
                    ctx.fillRect(midX, top, right - midX, midY - top);
                    ctx.fillStyle = options.bottomRight;
                    ctx.fillRect(midX, midY, right - midX, bottom - midY);
                    ctx.fillStyle = options.bottomLeft;
                    ctx.fillRect(left, midY, midX - left, bottom - midY);
                    ctx.restore();
                },
            };

            const containerWidth = document.querySelector('#quadrantsChart').parentElement.offsetWidth;
            const paddingValue = containerWidth * 0.1;
            // console.log(containerWidth, paddingValue);


            const quadrantsConfig = {
                type: "scatter",
                data: quadrantsData2,
                options: {
                    layout: {
                        padding: {
                            left: paddingValue,
                            right: paddingValue,
                            // top: 50,
                            // bottom: 50
                        }
                    },
                    aspectRatio: 1, // Menentukan rasio aspek grafik
                    maintainAspectRatio: false, // Menonaktifkan pemeliharaan rasio aspek
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Kenyataan'
                            },
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Harapan'
                            },
                        }
                    },
                    plugins: {
                        subtitle: {
                            display: true,
                            text: '*Nilai yang tertera adalah gap',
                            position: 'bottom',
                            align: 'start',
                            // color: 'red',
                            padding: {
                                top: 0,
                                bottom: 10,
                            }
                        },
                        legend: {
                            position: "bottom",
                            display: false,
                            onClick: null,
                        },
                        quadrants: {
                            topLeft: `hsl(0, 100%, 50%)`, // Misalnya menggunakan hue 0 (merah), saturation 100%, lightness 50%
                            bottomRight: `hsl(120, 100%, 50%)`, // Misalnya menggunakan hue 120 (hijau), saturation 100%, lightness 50%
                            bottomLeft: `hsl(60, 100%, 50%)`, // Misalnya menggunakan hue 60 (kuning), saturation 100%, lightness 50%
                            topRight: `hsl(200, 100%, 50%)`, // Misalnya menggunakan hue 240 (biru), saturation 100%, lightness 50%
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: "Grafik Importance Performance Analysis (IPA)",
                        },
                        tooltip: {
                            enabled: true,
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                const dataArr = ctx.chart.data.datasets;
                                const dataIndex = ctx.dataIndex;
                                const xValue = dataArr[ctx.datasetIndex].data[dataIndex].x;
                                const yValue = dataArr[ctx.datasetIndex].data[dataIndex].y;
                                const dimensionName = dataArr[ctx.datasetIndex].label ||
                                    ""; // Mendapatkan nama dimensi dari label dataset atau mengatur default value ke string kosong jika tidak ada label
                                const absoluteDifference = Math.abs(xValue - yValue);
                                const formattedValue = absoluteDifference.toLocaleString('id-ID', {
                                    minimumFractionDigits: 2
                                });
                                return `${dimensionName}: ${formattedValue}`; // Menggabungkan nama dimensi dengan nilai yang diformat
                            },
                            backgroundColor: 'white', // Set background color of labels to create outline effect
                            borderColor: 'black', // Set border color to create outline effect
                            borderWidth: 1,
                            align: 'right',
                            rotation: 0,
                            // anchor: 'end',
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        }
                    },
                },
                plugins: [ChartDataLabels, quadrants],
            };
            var quadrantsCtx = document.getElementById("quadrantsChart").getContext("2d");
            var quadrantsChart = new Chart(quadrantsCtx, quadrantsConfig);
            // END of QUADRANTS CHART

            // START OF PIE CHART
            // pie chart harapan

            const dataPieHarapan = {
                labels: ["Label 1", "Label 2", "Label 3"],
                datasets: [{
                    label: "Jumlah Responden",
                    data: [],
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 205, 86)",
                    ],
                    hoverOffset: 4,
                }, ],
            };

            const configPieHarapan = {
                type: "doughnut",
                data: dataPieHarapan,
                options: {
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: "Diagram Pie Harapan",
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = ((value * 100) / sum).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + "%";
                                return percentage;
                            },
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        }
                    },

                },
                plugins: [ChartDataLabels],
            };
            var ctxPieHarapan = document.getElementById("pieChartHarapan").getContext("2d");
            var pieChartHarapan = new Chart(ctxPieHarapan, configPieHarapan);

            // pie chart kenyataan
            const dataPieKenyataan = {
                labels: ["Label 1", "Label 2", "Label 3"],
                datasets: [{
                    label: "Jumlah Responden",
                    data: [],
                    hoverOffset: 4,
                }, ],
            };
            const configPieKenyataan = {
                type: "doughnut",
                data: dataPieKenyataan,
                options: {
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: "Diagram Pie Kenyataan",
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = ((value * 100) / sum).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + "%";
                                return percentage;
                            },
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        }
                    },
                },
                plugins: [ChartDataLabels],
            };
            var ctxPieKenyataan = document.getElementById("pieChartKenyataan").getContext("2d");
            var pieChartKenyataan = new Chart(ctxPieKenyataan, configPieKenyataan);
            // END OF PIE CHART

            // FOR LIVEWIRE UPDATE
            // for analisis gap
            $wire.on("chartUpdated", (dataGap) => {
                // For radar chart
                dataObject = dataGap[0]["radar"];
                const datanya = dataObject;
                radarChart.data = datanya;
                radarChart.update();
                // For stacked bar chart
                dataStackedObject = dataGap[0]["stackedBarGap"];
                const datanyaStacked = dataStackedObject;
                stackedGapChart.data.datasets[0].data = datanyaStacked[0]; // ini untuk data asli
                stackedGapChart.data.datasets[1].data = datanyaStacked[1]; // ini untuk data gap
                xScalesAxisMax = datanyaStacked[0][1] + datanyaStacked[1][1];
                stackedGapChart.options.scales.x.max = xScalesAxisMax;
                stackedGapChart.update();
                // For quadrants chart
                dataQuadrantsObject = dataGap[0]["quadrants"]["data"];
                const datanyaQuadrants = dataQuadrantsObject;
                quadrantsChart.data = datanyaQuadrants;
                dataQuadrantsAxisXObject = dataGap[0]["quadrants"]["axis"]["midX"];
                dataQuadrantsAxisYObject = dataGap[0]["quadrants"]["axis"]["midY"];
                // Inisialisasi nilai minimum dan maksimum untuk skala x dan y
                let minX = Infinity;
                let maxX = -Infinity;
                let minY = Infinity;
                let maxY = -Infinity;
                // Iterasi melalui setiap dataset
                quadrantsChart.data.datasets.forEach(dataset => {
                    // Iterasi melalui setiap titik data dalam dataset
                    dataset.data.forEach(point => {
                        // Periksa dan update nilai minimum dan maksimum untuk sumbu x
                        if (point.x < minX) minX = point.x;
                        if (point.x > maxX) maxX = point.x;
                        // Periksa dan update nilai minimum dan maksimum untuk sumbu y
                        if (point.y < minY) minY = point.y;
                        if (point.y > maxY) maxY = point.y;
                    });
                });
                // Tambahkan atau kurangi 0.01 dari nilai minimum dan maksimum untuk skala x dan y
                minX -= 0.01;
                maxX += 0.01;
                minY -= 0.01;
                maxY += 0.01;
                // Bulatkan nilai minimum dan maksimum ke nilai terdekat yang lebih rendah atau lebih tinggi
                minX = Math.floor(minX / 0.05) * 0.05;
                maxX = Math.ceil(maxX / 0.05) * 0.05;
                minY = Math.floor(minY / 0.05) * 0.05;
                maxY = Math.ceil(maxY / 0.05) * 0.05;
                // Memperbarui skala x dan y dengan nilai minimum dan maksimum yang dihitung
                quadrantsChart.options.scales.x.min = minX;
                quadrantsChart.options.scales.x.max = maxX;
                quadrantsChart.options.scales.y.min = minY;
                quadrantsChart.options.scales.y.max = maxY;
                // Memperbarui warna latar belakang dan border untuk setiap dataset
                quadrantsChart.data.datasets.forEach(dataset => {
                    dataset.backgroundColor = 'black';
                    dataset.borderColor = 'white';
                });
                quadrantsChart.update();

            });
            // For dimension chart
            $wire.on("chartPieUpdated", (dataPie) => {
                // console.log(dataPie);
                dataHarapanObject = dataPie[0]["Harapan"];
                // console.log(dataPie[0]);
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
                const backgroundColors = labels.map((label, index) =>
                    generateBrighterGradientColor(index, totalLabels),
                );
                pieChartHarapan.data.datasets[0].backgroundColor = backgroundColors;
                pieChartHarapan.update();
                pieChartKenyataan.data.datasets[0].backgroundColor = backgroundColors;
                dataKenyataanObject = dataPie[0]["Kenyataan"];
                const labels2 = Object.keys(dataKenyataanObject);
                const data2 = Object.values(dataKenyataanObject);
                pieChartKenyataan.data.labels = labels2;
                pieChartKenyataan.data.datasets[0].data = data2;
                pieChartKenyataan.update();
            });
        </script>
    @endscript
</div>
