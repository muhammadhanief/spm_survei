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
    </div>
    <div class="chart-container">
        <canvas wire:ignore id="monitoringChart"></canvas>
    </div>
    @script
        {{-- untuk select2 --}}
        <script>
            $(document).ready(function() {
                $('#surveyID').select2();
                $('#surveyID').on('change', function() {
                    var data = $('#surveyID').select2("val");
                    $wire.surveyID = data;
                });
            });

            const data = {
                labels: [
                    'Eating',
                    'Drinking',
                    'Sleeping',
                    'Designing',
                    'Coding',
                    'Cycling',
                    'Running'
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [65, 59, 90, 81, 56, 55, 40],
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }, {
                    label: 'My Second Dataset',
                    data: [28, 48, 40, 19, 96, 27, 100],
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(54, 162, 235)'
                }]
            };
            // config
            const config = {
                type: 'radar',
                data: data,
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
                            // text: `${Math.round((data.datasets[0].data[0] / data.datasets[0].data.reduce((acc, curr) => acc + curr)) * 100)}% Telah Mengisi`,
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
            $wire.on('chartUpdated', (dataRadar) => {
                dataObject = dataRadar[0];
                const datanya = dataObject;
                monitoringChart.data = datanya;
                monitoringChart.update();
            });
        </script>
        {{-- @push('js') --}}

        {{-- @endpush --}}
    @endscript
</div>
