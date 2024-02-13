<div class="pb-16 md:pb-32">

    <x-slot:title>Monitoring Survei</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Monitoring Survei
        </h2>
        <div class="flex flex-row py-2 gap-2 items-center">
            <x-button-small-0 color='blue' wire:click='updateAll'>Klik untuk update</x-button-small-0>
            <p class="text-sm text-gray-700 dark:text-gray-400">Terakhir diupdate {{ $lastUpdatedTime }}</p>
        </div>
        <div class="gap-6 mb-8 flex flex-col md:flex-row">
            <div class=" p-4 bg-white  rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Progres Pengisian
                </h4>
                {{-- <div class="chart-container"> --}}
                <div class="udin" style="position: relative; height:400px; width:400px">
                    <canvas id="monitoringChart"></canvas>
                </div>
                {{-- @script --}}
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

                            ctx.font = 'bold 20px sans-serif';
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
                        // plugins: [doughnutLabel],
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                title: {
                                    display: true,
                                    text: `${Math.round((data.datasets[0].data[0] / data.datasets[0].data.reduce((acc, curr) => acc + curr)) * 100)}% Telah Mengisi`,
                                    font: {
                                        size: 20,
                                    }
                                }
                            }
                        }

                    }

                    // render init block
                    var ctx = document.getElementById('monitoringChart');
                    var ctx = document.getElementById('monitoringChart').getContext('2d');

                    // Set ukuran kontainer saat inisialisasi
                    ctx.canvas.parentNode.style.height = '400px';
                    ctx.canvas.parentNode.style.width = '400px';

                    var monitoringChart = new Chart(
                        ctx, config
                    );

                    $wire.on('chartUpdated', (dataChartIndividual) => {
                        // Ambil label dan data dari objek
                        // const dataObject = dataChartIndividual[0];
                        // const labels = Object.keys(dataObject);
                        // const data = Object.values(dataObject);

                        // monitoringChart.data.labels = labels;
                        // monitoringChart.data.datasets[0].data = data;
                        // monitoringChart.options.plugins.title.text =
                        //     `${Math.round((data[0] / data.reduce((acc, curr) => acc + curr)) * 100)}% Telah Mengisi`;

                        // monitoringChart.update();
                        console.log("masuk ke sini")
                    });
                </script>
                {{-- @endscript --}}
            </div>
            <div class="max-w-md p-4 bg-white  rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Menu Aksi
                </h4>
                <x-button-small-0 color='green' wire:click='sendEmailReminder'>Kirim email reminder untuk yang
                    belum mengisi</x-button-small-0>
                <div wire:loading wire:target="sendEmailReminder">
                    <div class="alert alert-info" id="progressAlert">
                        Mengirim Email, mohon tunggu...
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.includes.monitoring.table')
    </div>
</div>
