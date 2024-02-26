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
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
                <!-- Card -->
                <div class="flex items-center p-4 h-full w-full bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg fill="currentColor" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v4c0 .3.1.5.3.7l3 3a1 1 0 0 0 1.4-1.4L13 11.6V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Tanggal Dimulai
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($survey->started_at)->translatedFormat('d F Y H:i') }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 h-full w-full bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                        <svg fill="currentColor" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v4c0 .3.1.5.3.7l3 3a1 1 0 0 0 1.4-1.4L13 11.6V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Tanggal Berakhir
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($survey->ended_at)->translatedFormat('d F Y H:i') }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 h-full w-full bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Expected Total Responden
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <input wire:model.live='expectedRespondents'
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Masukkan angka" value={{ $expectedRespondents }} />
                            <x-error-display name="expectedRespondents" />
                            <x-button-small-0 color='blue' class="my-2"
                                wire:click='updateExpectedResponden'>Update</x-button-small-0>
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 h-full w-full bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg fill="currentColor" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v4c0 .3.1.5.3.7l3 3a1 1 0 0 0 1.4-1.4L13 11.6V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Link Survei
                        </p>
                        {{-- <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            <a id="linkSurvey"
                                href="{{ route('survey.fill', ['surveyID' => $surveyID, 'uniqueCode' => $surveyID]) }}">
                                {{ route('survey.fill', ['surveyID' => $surveyID, 'uniqueCode' => $surveyID]) }}
                            </a>
                            <input type="text" value="Hello World" id="myInput">
                        </p> --}}
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Nama Akar Dimensi</span>
                            <input disabled value="{{ route('survey.fill', ['surveyID' => $surveyID]) }}" type="text"
                                id="linkSurvey"
                                class=" w-full pr-20 my-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                        </label>

                        <div class="flex flex-col gap-2">
                            <div>
                                <x-button-small-0 wire:click="copyLink" color='blue'>Salin
                                    Link</x-button-small-0>
                            </div>
                            <div>
                                <x-button-small-0 color='green' wire:click='sendEmailReminder'>Kirim email
                                    reminder</x-button-small-0>
                            </div>
                        </div>
                        <div wire:loading wire:target="sendEmailReminder">
                            <div class="alert alert-info" id="progressAlert">
                                Mengirim Email, mohon tunggu...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.includes.monitoring.table')
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
                    const dataObject = dataChartIndividual[0];
                    const labels = Object.keys(dataObject);
                    const data = Object.values(dataObject);

                    monitoringChart.data.labels = labels;
                    monitoringChart.data.datasets[0].data = data;
                    monitoringChart.options.plugins.title.text =
                        `${Math.round((data[0] / data.reduce((acc, curr) => acc + curr)) * 100)}% Telah Mengisi`;
                    monitoringChart.update();
                });

                $wire.on('copyLink', (link) => {
                    var copyText = document.getElementById("linkSurvey");
                    copyText.focus();
                    copyText.select();
                    console.log(copyText.value);
                    copyText.setSelectionRange(0, 99999); // For mobile devices
                    navigator.clipboard.writeText(copyText.value);
                    $wire.$dispatch('alert_copied')
                });
            </script>
            {{-- @endpush --}}
        @endscript
    </div>
</div>
