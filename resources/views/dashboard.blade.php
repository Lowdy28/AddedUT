<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control - UTEC Actividades') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjetas de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Estudiantes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 mr-4">
                            👥
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Estudiantes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">1,250</p>
                        </div>
                    </div>
                </div>

                <!-- Activas Hoy -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 mr-4">
                            📚
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Actividades Activas</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">24</p>
                        </div>
                    </div>
                </div>

                <!-- Inscripciones Hoy -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 mr-4">
                            ✅
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Inscripciones Hoy</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">47</p>
                        </div>
                    </div>
                </div>

                <!-- Cupo Promedio -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 mr-4">
                            📊
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Cupo Promedio</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">78%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Módulos Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Gestión de Eventos -->
                <a href="#" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-lg transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl mb-4">📅</div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Gestión de Eventos</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Crear y administrar actividades extracurriculares</p>
                    </div>
                </a>

                <!-- Control de Inscripciones -->
                <a href="#" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-lg transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl mb-4">📝</div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Control de Inscripciones</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Gestionar registros y cupos</p>
                    </div>
                </a>

                <!-- Reportes y Estadísticas -->
                <a href="#" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-lg transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl mb-4">📈</div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Reportes</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Estadísticas de participación</p>
                    </div>
                </a>
            </div>

            <!-- Actividad Reciente -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actividad Reciente</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Nueva inscripción en "Taller de Programación"</span>
                            </div>
                            <span class="text-xs text-gray-500">Hace 5 min</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Evento "Competencia Deportiva" actualizado</span>
                            </div>
                            <span class="text-xs text-gray-500">Hace 15 min</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Usuario registrado: María González</span>
                            </div>
                            <span class="text-xs text-gray-500">Hace 30 min</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>