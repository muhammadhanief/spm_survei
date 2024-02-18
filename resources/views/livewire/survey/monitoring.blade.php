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
                <div class="chart-container">
                    <canvas wire:ignore id="monitoringChart"></canvas>
                </div>

                @script
                    {{-- @push('js') --}}
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
                                    },

                                }
                            }

                        }

                        // render init block
                        var ctx = document.getElementById('monitoringChart'); // node
                        var ctx = document.getElementById('monitoringChart').getContext('2d'); // 2d context
                        // ctx.canvas.width = 700; // Sesuaikan dengan lebar yang diinginkan
                        // ctx.canvas.height = 400; // Sesuaikan dengan tinggi yang diinginkan
                        var monitoringChart = new Chart(
                            ctx, config
                        );

                        var canvas = monitoringChart.canvas;

                        // realtime update
                        $wire.on('chartUpdated', (dataChartIndividual) => {
                            // Ambil label dan data dari objek
                            console.log(dataChartIndividual);
                            const dataObject = dataChartIndividual[0];
                            const labels = Object.keys(dataObject);
                            const data = Object.values(dataObject);

                            monitoringChart.data.labels = labels;
                            monitoringChart.data.datasets[0].data = data;
                            monitoringChart.options.plugins.title.text =
                                `${Math.round((data[0] / data.reduce((acc, curr) => acc + curr)) * 100)}% Telah Mengisi`;
                            monitoringChart.update();
                        });
                    </script>
                    {{-- @endpush --}}
                @endscript
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
