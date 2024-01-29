<div class="pb-16 md:pb-32">

    <x-slot:title>Monitoring Survei</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Buat Survei
        </h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white  rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Progres Pengisian
                </h4>
                <div class="chart-container">
                    <canvas id="monitoringChart"></canvas>
                    {{-- <div wire:poll.2s='getDataChart'></div> --}}
                </div>

                @script
                    <script>
                        const data = {
                            labels: @json(array_keys($dataChartIndividual)),
                            datasets: [{
                                data: @json(array_values($dataChartIndividual)),
                                // backgroundColor: ["#0694a2", "#1c64f2", "#7e3af2"],
                                label: "Dataset 1",
                                borderWidth: 1,
                            }]

                        }

                        const doughnutLabel = {
                            id: 'doughnutLabel',
                            beforeDatasetsDraw(chart, args, pluginOptions) {
                                const {
                                    ctx,
                                    data
                                } = chart;
                                ctx.save();

                                const totalPeople = data.datasets[0].data.reduce((acc, curr) => acc + curr);
                                const submitted = data.datasets[0].data[0];
                                const percentage = Math.round((submitted / totalPeople) * 100);

                                const xCoor = chart.getDatasetMeta(0).data[0].x;
                                const yCoor = chart.getDatasetMeta(0).data[0].y;

                                ctx.font = 'bold 30px sans-serif';
                                ctx.fillStyle = 'rgba(54, 162, 235, 1)';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(`${percentage}% Mengisi`, xCoor, yCoor);
                            }
                        }

                        // config
                        const config = {
                            type: 'doughnut',
                            data,
                            plugins: [doughnutLabel],
                        }

                        // render init block
                        var ctx = document.getElementById('monitoringChart'); // node
                        var ctx = document.getElementById('monitoringChart').getContext('2d'); // 2d context


                        var monitoringChart = new Chart(
                            ctx, config
                        );

                        // realtime update
                        $wire.on('chartUpdated', (dataChartIndividual) => {
                            // Perbarui chart di sini
                            monitoringChart.data.labels = @json(array_keys($dataChartIndividual));
                            monitoringChart.data.datasets[0].data = @json(array_values($dataChartIndividual));
                            monitoringChart.update();
                        });
                    </script>
                @endscript
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Lines
                </h4>
                <div>
                    <canvas id="line"></canvas>
                </div>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-teal-500 rounded-full"></span>
                        <span>Organic</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                        <span>Paid</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
