@extends('client.layout.app')

@section('title', 'Book Repair Service')

@section('content')
@section('content')
@php
$user = (object)[
'name' => 'John Doe',
'email' => 'john@example.com',
'phone' => '123-456-7890',
'address' => '123 Example Street, HCMC',
'created_at' => now()->subYears(2),
]
@endphp

<div x-data="bookServiceData()" class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Book Repair Service</h1>
            <p class="text-gray-600 mt-1">Professional device repair with warranty and quality guarantee</p>
        </div>
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <template x-for="(stepName, index) in steps" :key="index">
                <div class="flex items-center">
                    <span :class="{
                        'bg-green-100 text-green-800': step > index + 1,
                        'bg-blue-600 text-white': step === index + 1,
                        'bg-gray-100 text-gray-500': step < index + 1
                    }" class="px-3 py-1 rounded-full font-medium">
                        <template x-if="step > index + 1">
                            <span>✓</span>
                        </template>
                        <template x-if="step <= index + 1">
                            <span x-text="`${index + 1}.`"></span>
                        </template>
                        <span x-text="stepName" class="ml-1"></span>
                    </span>
                    <template x-if="index < steps.length - 1">
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-8">
        <!-- Step 1: Device Type Selection -->
        <div x-show="step === 1" class="space-y-8">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Select Your Device Type</h2>
                <p class="text-gray-600">Choose the type of device you need repaired</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <template x-for="device in deviceTypes" :key="device.id">
                    <button @click="selectedDeviceType = device.id"
                        :class="{
                                'border-blue-500 bg-blue-50 shadow-lg transform scale-105': selectedDeviceType === device.id,
                                'border-gray-200 hover:border-gray-300 hover:shadow-md': selectedDeviceType !== device.id
                            }"
                        class="group p-6 rounded-xl border-2 transition-all duration-200 hover:shadow-lg">
                        <div :class="device.color" class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i :class="device.icon" class="text-2xl text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2" x-text="device.label"></h3>
                        <p class="text-sm text-gray-600" x-text="device.description"></p>
                    </button>
                </template>
            </div>
            <div class="flex justify-end">
                <button @click="nextStep()" :disabled="!selectedDeviceType"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium">
                    <span>Continue</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Step 2: Issue Category Selection -->
        <div x-show="step === 2" class="space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">What's wrong with your <span x-text="selectedDeviceType"></span>?</h2>
                    <p class="text-gray-600">Select the category that best describes your issue</p>
                </div>
                <button @click="prevStep()" class="text-blue-600 hover:text-blue-800 font-medium">← Back</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="category in getCurrentDeviceIssues()" :key="category.id">
                    <div @click="selectedIssueCategory = category.id"
                        :class="{
                             'border-blue-500 bg-blue-50 shadow-lg': selectedIssueCategory === category.id,
                             'border-gray-200 hover:border-gray-300': selectedIssueCategory !== category.id
                         }"
                        class="group p-6 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:shadow-lg">
                        <div class="flex items-center space-x-3 mb-4">
                            <i :class="category.icon + ' ' + category.color" class="text-xl"></i>
                            <h3 class="text-lg font-semibold text-gray-900" x-text="category.label"></h3>
                        </div>
                        <div class="space-y-2 mb-4">
                            <template x-for="(issue, index) in category.issues.slice(0, 3)" :key="index">
                                <p class="text-sm text-gray-600 flex items-center">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-2"></span>
                                    <span x-text="issue"></span>
                                </p>
                            </template>
                            <template x-if="category.issues.length > 3">
                                <p class="text-sm text-blue-600 font-medium" x-text="`+${category.issues.length - 3} more issues`"></p>
                            </template>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                                <span x-text="category.avgRepairTime"></span>
                            </span>
                            <span :class="{
                                'bg-green-100 text-green-700': category.difficulty === 'Easy',
                                'bg-yellow-100 text-yellow-700': category.difficulty === 'Medium',
                                'bg-red-100 text-red-700': category.difficulty === 'Hard'
                            }" class="px-2 py-1 rounded-full" x-text="category.difficulty"></span>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-end">
                <button @click="nextStep()" :disabled="!selectedIssueCategory"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium">
                    <span>Continue</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Step 3: Device Details -->
        <div x-show="step === 3" class="space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Device Information</h2>
                    <p class="text-gray-600">Please provide details about your <span x-text="selectedDeviceType"></span></p>
                </div>
                <button @click="prevStep()" class="text-blue-600 hover:text-blue-800 font-medium">← Back</button>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Device Model *</label>
                        <input type="text" x-model="deviceDetails.model"
                            :placeholder="getModelPlaceholder()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span x-text="selectedDeviceType === 'Laptop' ? 'Serial Number' : 'IMEI/Serial Number'"></span>
                        </label>
                        <input type="text" x-model="deviceDetails.imei"
                            placeholder="Enter IMEI or serial number"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Date (Optional)</label>
                        <input type="date" x-model="deviceDetails.purchaseDate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Detailed Issue Description *</label>
                        <textarea x-model="deviceDetails.issueDescription" rows="6"
                            placeholder="Please describe the problem in detail. When did it start? What were you doing when it happened? Any error messages or unusual behavior?"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urgency Level</label>
                            <select x-model="deviceDetails.urgency"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="normal">Normal (2-3 days)</option>
                                <option value="urgent">Urgent (+50% fee, same day)</option>
                            </select>
                        </div>
                        <div class="flex flex-col justify-center space-y-3">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" x-model="deviceDetails.hasWarranty" class="text-blue-600 rounded">
                                <span class="text-sm font-medium text-gray-700">Still under warranty</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" x-model="deviceDetails.previousRepairs" class="text-blue-600 rounded">
                                <span class="text-sm font-medium text-gray-700">Previous repairs</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button @click="nextStep()" :disabled="!deviceDetails.model || !deviceDetails.issueDescription"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium">
                    <span>Continue</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Step 4: Service Selection -->
        <div x-show="step === 4" class="space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Select Repair Service</h2>
                    <p class="text-gray-600">Choose the repair service that matches your device issue</p>
                </div>
                <button @click="prevStep()" class="text-blue-600 hover:text-blue-800 font-medium">← Back</button>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">
                                Showing services for <span x-text="selectedDeviceType"></span> - <span x-text="getSelectedCategoryLabel()"></span>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>All services include warranty</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <template x-for="service in getAvailableServices()" :key="service.id">
                    <div @click="selectedService = service"
                        :class="{
                             'border-blue-500 bg-blue-50 shadow-lg': selectedService?.id === service.id,
                             'border-gray-200 hover:border-gray-300': selectedService?.id !== service.id
                         }"
                        class="group relative p-6 rounded-xl border-2 cursor-pointer transition-all duration-200 hover:shadow-lg">

                        <template x-if="service.popularity > 80">
                            <div class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Popular
                            </div>
                        </template>

                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-1" x-text="service.name"></h3>
                                <p class="text-sm text-gray-600 mb-2" x-text="service.description"></p>

                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="flex items-center">
                                        <template x-for="i in 5" :key="i">
                                            <svg :class="i <= Math.floor(service.rating) ? 'text-yellow-400' : 'text-gray-300'"
                                                class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </template>
                                    </div>
                                    <span class="text-sm text-gray-600" x-text="`${service.rating} (${service.reviews} reviews)`"></span>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500 line-through" x-text="formatPrice(service.originalPrice)"></span>
                                    <span class="text-2xl font-bold text-blue-600" x-text="formatPrice(service.price)"></span>
                                </div>
                                <div class="text-sm text-green-600 font-medium" x-text="`Save ${formatPrice(service.originalPrice - service.price)}`"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                                <span x-text="service.estimatedTime"></span>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span x-text="`${service.warranty} days warranty`"></span>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <span :class="{
                                    'bg-green-100 text-green-700': service.difficulty === 'Easy',
                                    'bg-yellow-100 text-yellow-700': service.difficulty === 'Medium',
                                    'bg-red-100 text-red-700': service.difficulty === 'Hard'
                                }" class="px-2 py-1 rounded-full text-xs" x-text="service.difficulty"></span>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Quality tested</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">What's included:</h4>
                            <div class="grid grid-cols-2 gap-1">
                                <template x-for="item in service.includes" :key="item">
                                    <div class="flex items-center space-x-1 text-sm text-gray-600">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span x-text="item"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <template x-if="deviceDetails.urgency === 'urgent'">
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                                <div class="flex items-center space-x-2 mb-1">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <polygon points="13,2 3,14 12,14 11,22 21,10 12,10 13,2"></polygon>
                                    </svg>
                                    <span class="text-sm font-medium text-orange-800">Rush Job Pricing</span>
                                </div>
                                <div class="text-sm text-orange-700">
                                    Same-day service: <span class="font-bold" x-text="formatPrice(service.price * 1.5)"></span>
                                    <span class="text-xs ml-1">(+50% rush fee)</span>
                                </div>
                            </div>
                        </template>

                        <template x-if="selectedService?.id === service.id">
                            <div class="absolute top-4 right-4">
                                <svg class="w-6 h-6 text-blue-600 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <div class="flex justify-end">
                <button @click="nextStep()" :disabled="!selectedService"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium">
                    <span>Continue</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Step 5: Confirmation -->
        <div x-show="step === 5" class="space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Confirm Your Service Booking</h2>
                    <p class="text-gray-600">Review your booking details and schedule your appointment</p>
                </div>
                <button @click="prevStep()" class="text-blue-600 hover:text-blue-800 font-medium">← Back</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <!-- Service Summary -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Device:</span>
                                <span class="font-medium" x-text="`${selectedDeviceType} ${deviceDetails.model}`"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Issue Category:</span>
                                <span class="font-medium" x-text="getSelectedCategoryLabel()"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service:</span>
                                <span class="font-medium" x-text="selectedService?.name"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Estimated Time:</span>
                                <span class="font-medium" x-text="selectedService?.estimatedTime"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Warranty:</span>
                                <span class="font-medium" x-text="`${selectedService?.warranty} days`"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Urgency:</span>
                                <span :class="deviceDetails.urgency === 'urgent' ? 'text-orange-600' : 'text-green-600'"
                                    class="font-medium"
                                    x-text="deviceDetails.urgency === 'urgent' ? 'Urgent (Same Day)' : 'Normal (2-3 Days)'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Method -->
                    <div class="bg-white border rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Method</h3>
                        <div class="space-y-3">
                            <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50">
                                <input type="radio" name="deliveryMethod" value="pickup" x-model="deliveryMethod" class="text-blue-600">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium">Bring to store</span>
                                        <p class="text-sm text-gray-600">Drop off and pick up at our location</p>
                                    </div>
                                </div>
                                <span class="ml-auto text-green-600 font-medium">Free</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50">
                                <input type="radio" name="deliveryMethod" value="delivery" x-model="deliveryMethod" class="text-blue-600">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM21 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium">Pickup & delivery service</span>
                                        <p class="text-sm text-gray-600">We collect and return your device</p>
                                    </div>
                                </div>
                                <span class="ml-auto text-blue-600 font-medium">+$25</span>
                            </label>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="bg-white border rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preferred Schedule</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                                <input type="date" x-model="selectedDate" :min="new Date().toISOString().split('T')[0]"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Time *</label>
                                <select x-model="selectedTime"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select time slot</option>
                                    <template x-for="time in timeSlots" :key="time">
                                        <option :value="time" x-text="time"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Info & Total -->
                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>

                                <span class="font-medium">{{ $user->name }}</span>

                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="font-medium">{{ $user->name->phone ?? 'Not provided' }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium">{{ $user->email }}</span>

                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="font-medium">{{ $user->address ?? 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cost Breakdown</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span>Base service price:</span>
                                <span class="font-medium" x-text="formatPrice(selectedService?.price || 0)"></span>
                            </div>
                            <template x-if="deviceDetails.urgency === 'urgent'">
                                <div class="flex justify-between text-orange-600">
                                    <span>Rush fee (50%):</span>
                                    <span class="font-medium" x-text="`+${formatPrice((selectedService?.price || 0) * 0.5)}`"></span>
                                </div>
                            </template>
                            <template x-if="deliveryMethod === 'delivery'">
                                <div class="flex justify-between">
                                    <span>Pickup & delivery:</span>
                                    <span class="font-medium">+$25.00</span>
                                </div>
                            </template>
                            <div class="border-t border-blue-200 pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total:</span>
                                    <span class="text-blue-600" x-text="formatPrice(getTotalCost())"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center space-x-2 mb-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium text-green-800">Warranty Included</span>
                        </div>
                        <p class="text-sm text-green-700" x-text="`Your repair comes with a ${selectedService?.warranty}-day warranty covering parts and labor.`"></p>
                    </div>

                    <form @submit.prevent="submitBooking()">
                        <button type="submit" :disabled="!selectedDate || !selectedTime"
                            class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-lg">
                            Confirm Service Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function bookServiceData() {
        return {
            step: 1,
            steps: ['Device Type', 'Issue Category', 'Device Details', 'Service Selection', 'Confirmation'],
            selectedDeviceType: '',
            selectedIssueCategory: '',
            selectedService: null,
            deviceDetails: {
                model: '',
                imei: '',
                issueDescription: '',
                urgency: 'normal',
                hasWarranty: false,
                previousRepairs: false,
                purchaseDate: ''
            },
            deliveryMethod: 'pickup',
            selectedDate: '',
            selectedTime: '',

            deviceTypes: [{
                    id: 'iPhone',
                    label: 'iPhone',
                    icon: 'fas fa-mobile-alt',
                    color: 'bg-blue-500',
                    description: 'All iPhone models and generations'
                },
                {
                    id: 'Android',
                    label: 'Android',
                    icon: 'fab fa-android',
                    color: 'bg-green-500',
                    description: 'Samsung, Google, OnePlus, etc.'
                },
                {
                    id: 'Laptop',
                    label: 'Laptop',
                    icon: 'fas fa-laptop',
                    color: 'bg-purple-500',
                    description: 'MacBook, Windows laptops'
                },
                {
                    id: 'Tablet',
                    label: 'Tablet',
                    icon: 'fas fa-tablet-alt',
                    color: 'bg-orange-500',
                    description: 'iPad, Android tablets'
                },
                {
                    id: 'Smartwatch',
                    label: 'Smartwatch',
                    icon: 'fas fa-clock',
                    color: 'bg-pink-500',
                    description: 'Apple Watch, Samsung Galaxy Watch'
                }
            ],

            timeSlots: [
                '8:00 - 9:00', '9:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00',
                '13:00 - 14:00', '14:00 - 15:00', '15:00 - 16:00', '16:00 - 17:00'
            ],

            deviceIssues: {
                iPhone: [{
                        id: 'screen',
                        label: 'Screen Issues',
                        icon: 'fas fa-mobile-alt',
                        color: 'text-red-600',
                        issues: ['Cracked screen', 'Black screen', 'Touch not working', 'Dead pixels', 'Screen flickering'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'battery',
                        label: 'Battery Problems',
                        icon: 'fas fa-battery-half',
                        color: 'text-green-600',
                        issues: ['Fast drain', 'Not charging', 'Overheating', 'Swollen battery', 'Random shutdowns'],
                        avgRepairTime: '30-60 minutes',
                        difficulty: 'Easy'
                    },
                    {
                        id: 'camera',
                        label: 'Camera Issues',
                        icon: 'fas fa-camera',
                        color: 'text-purple-600',
                        issues: ['Blurry photos', 'Camera not working', 'Flash not working', 'Front camera issues', 'Lens cracked'],
                        avgRepairTime: '45-90 minutes',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'audio',
                        label: 'Audio Problems',
                        icon: 'fas fa-volume-up',
                        color: 'text-blue-600',
                        issues: ['No sound', 'Microphone not working', 'Speaker issues', 'Headphone jack problems'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'other',
                        label: 'Other Issues',
                        icon: 'fas fa-exclamation-triangle',
                        color: 'text-orange-600',
                        issues: ['Water damage', 'Won\'t turn on', 'Software issues', 'Charging port problems', 'Button not working'],
                        avgRepairTime: '2-4 hours',
                        difficulty: 'Hard'
                    }
                ],
                Android: [{
                        id: 'screen',
                        label: 'Screen Issues',
                        icon: 'fas fa-mobile-alt',
                        color: 'text-red-600',
                        issues: ['Cracked screen', 'Display not working', 'Touch sensitivity', 'Screen flickering', 'Color distortion'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'battery',
                        label: 'Battery Problems',
                        icon: 'fas fa-battery-half',
                        color: 'text-green-600',
                        issues: ['Quick discharge', 'Charging issues', 'Battery swelling', 'Overheating', 'Slow charging'],
                        avgRepairTime: '45-90 minutes',
                        difficulty: 'Easy'
                    },
                    {
                        id: 'camera',
                        label: 'Camera Issues',
                        icon: 'fas fa-camera',
                        color: 'text-purple-600',
                        issues: ['Camera app crashes', 'Blurry images', 'Flash malfunction', 'Lens damage', 'Focus problems'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'performance',
                        label: 'Performance Issues',
                        icon: 'fas fa-tachometer-alt',
                        color: 'text-blue-600',
                        issues: ['Slow performance', 'App crashes', 'Storage full', 'System updates failing', 'Freezing'],
                        avgRepairTime: '1-3 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'other',
                        label: 'Other Issues',
                        icon: 'fas fa-exclamation-triangle',
                        color: 'text-orange-600',
                        issues: ['Water damage', 'Boot loop', 'Network issues', 'Hardware failure', 'Sensor problems'],
                        avgRepairTime: '2-5 hours',
                        difficulty: 'Hard'
                    }
                ],
                Laptop: [{
                        id: 'screen',
                        label: 'Display Issues',
                        icon: 'fas fa-laptop',
                        color: 'text-red-600',
                        issues: ['Cracked screen', 'No display', 'Flickering', 'Dead pixels', 'Backlight issues', 'Lines on screen'],
                        avgRepairTime: '2-4 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'keyboard',
                        label: 'Keyboard/Trackpad',
                        icon: 'fas fa-keyboard',
                        color: 'text-blue-600',
                        issues: ['Keys not working', 'Trackpad issues', 'Sticky keys', 'Backlight problems', 'Key replacement'],
                        avgRepairTime: '1-3 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'battery',
                        label: 'Power Issues',
                        icon: 'fas fa-battery-half',
                        color: 'text-green-600',
                        issues: ['Won\'t charge', 'Battery drain', 'Power button issues', 'Adapter problems', 'Random shutdowns'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Easy'
                    },
                    {
                        id: 'performance',
                        label: 'Performance Issues',
                        icon: 'fas fa-tachometer-alt',
                        color: 'text-purple-600',
                        issues: ['Slow startup', 'Overheating', 'Fan noise', 'Blue screen', 'Virus removal', 'Memory issues'],
                        avgRepairTime: '2-6 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'hardware',
                        label: 'Hardware Issues',
                        icon: 'fas fa-exclamation-triangle',
                        color: 'text-orange-600',
                        issues: ['Hard drive failure', 'RAM issues', 'Motherboard problems', 'Ports not working', 'Audio issues'],
                        avgRepairTime: '3-8 hours',
                        difficulty: 'Hard'
                    }
                ],
                Tablet: [{
                        id: 'screen',
                        label: 'Screen Issues',
                        icon: 'fas fa-tablet-alt',
                        color: 'text-red-600',
                        issues: ['Cracked screen', 'Touch not responsive', 'Display lines', 'Screen rotation issues', 'Dead zones'],
                        avgRepairTime: '1-3 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'battery',
                        label: 'Battery Issues',
                        icon: 'fas fa-battery-half',
                        color: 'text-green-600',
                        issues: ['Fast battery drain', 'Not charging', 'Charging port loose', 'Battery swelling', 'Overheating'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'software',
                        label: 'Software Issues',
                        icon: 'fas fa-cog',
                        color: 'text-blue-600',
                        issues: ['App crashes', 'System freezing', 'Update problems', 'Factory reset needed', 'Performance issues'],
                        avgRepairTime: '1-4 hours',
                        difficulty: 'Easy'
                    },
                    {
                        id: 'audio',
                        label: 'Audio/Camera',
                        icon: 'fas fa-camera',
                        color: 'text-purple-600',
                        issues: ['No sound', 'Camera not working', 'Microphone issues', 'Speaker problems', 'Video recording issues'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'other',
                        label: 'Other Issues',
                        icon: 'fas fa-exclamation-triangle',
                        color: 'text-orange-600',
                        issues: ['Water damage', 'Won\'t turn on', 'WiFi issues', 'Bluetooth problems', 'Button not working'],
                        avgRepairTime: '2-5 hours',
                        difficulty: 'Hard'
                    }
                ],
                Smartwatch: [{
                        id: 'screen',
                        label: 'Display Issues',
                        icon: 'fas fa-clock',
                        color: 'text-red-600',
                        issues: ['Cracked screen', 'Screen not turning on', 'Touch not working', 'Display dim', 'Dead pixels'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Hard'
                    },
                    {
                        id: 'battery',
                        label: 'Battery Problems',
                        icon: 'fas fa-battery-half',
                        color: 'text-green-600',
                        issues: ['Battery drain', 'Not charging', 'Charging dock issues', 'Battery swelling', 'Random shutdowns'],
                        avgRepairTime: '1-2 hours',
                        difficulty: 'Hard'
                    },
                    {
                        id: 'sensors',
                        label: 'Sensors/Features',
                        icon: 'fas fa-heartbeat',
                        color: 'text-blue-600',
                        issues: ['Heart rate not working', 'GPS issues', 'Step counter problems', 'Water resistance lost', 'Fitness tracking'],
                        avgRepairTime: '2-3 hours',
                        difficulty: 'Hard'
                    },
                    {
                        id: 'connectivity',
                        label: 'Connectivity Issues',
                        icon: 'fas fa-wifi',
                        color: 'text-purple-600',
                        issues: ['Bluetooth issues', 'WiFi problems', 'Phone sync issues', 'App crashes', 'Notification problems'],
                        avgRepairTime: '1-3 hours',
                        difficulty: 'Medium'
                    },
                    {
                        id: 'physical',
                        label: 'Physical Damage',
                        icon: 'fas fa-exclamation-triangle',
                        color: 'text-orange-600',
                        issues: ['Water damage', 'Crown not working', 'Band issues', 'Button problems', 'Case damage'],
                        avgRepairTime: '2-4 hours',
                        difficulty: 'Hard'
                    }
                ]
            },

            nextStep() {
                if (this.step < 5) this.step++;
            },

            prevStep() {
                if (this.step > 1) this.step--;
            },

            getCurrentDeviceIssues() {
                return this.deviceIssues[this.selectedDeviceType] || [];
            },

            getSelectedCategoryLabel() {
                const issues = this.getCurrentDeviceIssues();
                const category = issues.find(cat => cat.id === this.selectedIssueCategory);
                return category ? category.label : '';
            },

            getModelPlaceholder() {
                const placeholders = {
                    'iPhone': 'iPhone 14 Pro Max',
                    'Android': 'Samsung Galaxy S23 Ultra',
                    'Laptop': 'MacBook Pro 2023 13"',
                    'Tablet': 'iPad Air 5th Gen',
                    'Smartwatch': 'Apple Watch Series 8'
                };
                return `e.g., ${placeholders[this.selectedDeviceType] || 'Device Model'}`;
            },

            getAvailableServices() {
                const baseServices = [{
                        id: '1',
                        name: 'Screen Replacement',
                        category: 'Display Repair',
                        price: this.getServicePrice('screen'),
                        originalPrice: this.getServicePrice('screen') * 1.25,
                        estimatedTime: this.selectedDeviceType === 'Laptop' ? '2-4 hours' : '1-2 hours',
                        difficulty: 'Medium',
                        description: 'Complete screen assembly replacement with high-quality parts. Includes LCD/OLED display and digitizer.',
                        warranty: 90,
                        includes: ['Screen assembly', 'Installation', 'Quality check', 'Warranty'],
                        popularity: 95,
                        rating: 4.8,
                        reviews: 1247
                    },
                    {
                        id: '2',
                        name: 'Battery Replacement',
                        category: 'Power System',
                        price: this.getServicePrice('battery'),
                        originalPrice: this.getServicePrice('battery') * 1.34,
                        estimatedTime: this.selectedDeviceType === 'Laptop' ? '1-2 hours' : '30-60 minutes',
                        difficulty: 'Easy',
                        description: 'Replace worn-out battery with genuine or high-quality compatible battery. Restore your device\'s battery life.',
                        warranty: 180,
                        includes: ['New battery', 'Installation', 'Battery calibration', 'Disposal of old battery'],
                        popularity: 88,
                        rating: 4.9,
                        reviews: 892
                    },
                    {
                        id: '3',
                        name: 'Water Damage Restoration',
                        category: 'Liquid Damage',
                        price: this.getServicePrice('water'),
                        originalPrice: this.getServicePrice('water') * 1.4,
                        estimatedTime: '4-8 hours',
                        difficulty: 'Hard',
                        description: 'Complete liquid damage assessment and restoration service. Professional cleaning and component repair.',
                        warranty: 30,
                        includes: ['Diagnostic', 'Cleaning service', 'Component repair', 'Testing'],
                        popularity: 65,
                        rating: 4.6,
                        reviews: 324
                    },
                    {
                        id: '4',
                        name: 'Camera Repair',
                        category: 'Camera System',
                        price: this.getServicePrice('camera'),
                        originalPrice: this.getServicePrice('camera') * 1.33,
                        estimatedTime: '1-3 hours',
                        difficulty: 'Medium',
                        description: 'Fix camera issues including blurry photos, camera not working, flash problems, and lens replacement.',
                        warranty: 90,
                        includes: ['Camera repair', 'Lens cleaning', 'Software fix', 'Testing'],
                        popularity: 72,
                        rating: 4.7,
                        reviews: 456
                    }
                ];

                return baseServices;
            },

            getServicePrice(serviceType) {
                const prices = {
                    'iPhone': {
                        screen: 199,
                        battery: 89,
                        water: 149,
                        camera: 119
                    },
                    'Android': {
                        screen: 149,
                        battery: 79,
                        water: 129,
                        camera: 99
                    },
                    'Laptop': {
                        screen: 299,
                        battery: 129,
                        water: 199,
                        camera: 89
                    },
                    'Tablet': {
                        screen: 179,
                        battery: 99,
                        water: 139,
                        camera: 109
                    },
                    'Smartwatch': {
                        screen: 249,
                        battery: 119,
                        water: 169,
                        camera: 139
                    }
                };

                return prices[this.selectedDeviceType]?.[serviceType] || 100;
            },

            formatPrice(price) {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(price);
            },

            getTotalCost() {
                let total = this.selectedService ? this.selectedService.price : 0;
                if (this.deliveryMethod === 'delivery') {
                    total += 25;
                }
                if (this.deviceDetails.urgency === 'urgent') {
                    total *= 1.5;
                }
                return total;
            },

            async submitBooking() {
                const bookingData = {
                    device_type: this.selectedDeviceType,
                    device_model: this.deviceDetails.model,
                    device_imei: this.deviceDetails.imei,
                    issue_category: this.selectedIssueCategory,
                    issue_description: this.deviceDetails.issueDescription,
                    service_id: this.selectedService.id,
                    service_name: this.selectedService.name,
                    urgency: this.deviceDetails.urgency,
                    has_warranty: this.deviceDetails.hasWarranty,
                    previous_repairs: this.deviceDetails.previousRepairs,
                    purchase_date: this.deviceDetails.purchaseDate,
                    delivery_method: this.deliveryMethod,
                    scheduled_date: this.selectedDate,
                    scheduled_time: this.selectedTime,
                    total_cost: this.getTotalCost()
                };

                try {
                    const response = await fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(bookingData)
                    });

                    if (response.ok) {
                        alert('Service booking successful! We will contact you shortly.');
                        window.location.href = '';
                    } else {
                        alert('There was an error processing your booking. Please try again.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('There was an error processing your booking. Please try again.');
                }
            }
        }
    }
</script>
@endsection