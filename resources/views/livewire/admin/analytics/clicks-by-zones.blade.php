<div>
    <!-- Add these styles to your main layout or this view -->
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .stat-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .stat-card-blue {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .stat-card-green {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
</style>



<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  

    <!-- Denomination Analytics -->
    <div x-data="{ openDropdown: null }" class="space-y-4">
        @foreach($zonesWithClicks as $data)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden card-hover">
                <button 
                    @click="openDropdown === {{ $loop->index }} ? openDropdown = null : openDropdown = {{ $loop->index }}"
                    class="w-full p-6 hover:bg-gray-50 transition-all duration-200"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex p-2 border border-black/40 rounded-md">
                                <x-heroicon-s-home-modern class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                            </div>
                            <div class="text-left">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $data['zone']->name }}</h3>
                                <p class="text-sm text-gray-500">No. Denominations: {{ $data['zone']->denominations->count() ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-8">
                            <div class="text-center">
                                <div class="flex items-center space-x-2">
                                    <i class="fab fa-facebook text-blue-600"></i>
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($data['facebook_clicks']) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Facebook</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="flex items-center space-x-2">
                                    <i class="fab fa-youtube text-red-600"></i>
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($data['youtube_clicks']) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">YouTube</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">{{ number_format($data['total_clicks']) }}</div>
                                <p class="text-xs text-gray-500 mt-1">Total Clicks</p>
                            </div>
                            
                            <div class="ml-4">
                                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200" 
                                   :class="openDropdown ===  $loop->index ? 'rotate-180' : ''"></i>
                            </div>
                        </div>
                    </div>
                </button>

                <!-- Expanded Content -->
                <div 
                    x-show="openDropdown === {{ $loop->index }}"
                    x-collapse
                    class="border-t border-gray-100 bg-gray-50"
                >
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Clicks by Device type-->
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                                    Visits by Devices
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Mobile Phones</span>
                                        <span class="font-semibold text-blue-600">{{ number_format($data['facebook_clicks']) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Desktops</span>
                                        <span class="font-semibold text-red-600">{{ number_format($data['youtube_clicks']) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Total Engagement</span>
                                        <span class="font-semibold text-green-600">{{ number_format($data['total_clicks']) }}</span>
                                    </div>
                                 
                                </div>
                            </div>


                            <!-- Quick Actions -->
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                                    Quick Actions
                                </h4>
                                <div class="space-y-3">
                                    <a href="#" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 py-3 px-4 rounded-lg transition flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Detailed Report
                                    </a>
                                    <button  class="w-full bg-green-50 hover:bg-green-100 text-green-700 py-3 px-4 rounded-lg transition flex items-center justify-center">
                                        <i class="fas fa-download mr-2"></i>
                                        Export Analytics
                                    </button>
                                    <a  class="w-full bg-purple-50 hover:bg-purple-100 text-purple-700 py-3 px-4 rounded-lg transition flex items-center justify-center">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        View Denomination
                                    </a>
                                </div>
                            </div>
                        </div>

                  
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($zonesWithClicks->isEmpty())
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-chart-bar text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Analytics Data</h3>
            <p class="text-gray-500 mb-6">Start creating and sharing links to see analytics data here.</p>
            <a href="{{ route('links.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>
                Create Your First Link
            </a>
        </div>
    @endif
</div>

<!-- Add this JavaScript for export functionality -->
<script>
function exportDenominationData(denominationId) {
    // Add your export logic here
    console.log('Exporting data for denomination ID:', denominationId);
    // You can make an AJAX call to your export endpoint
    // window.location.href = '/export/denomination/' + denominationId;
}

// Add smooth scrolling and other interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add any additional JavaScript functionality here
    console.log('Analytics dashboard loaded');
});
</script>
</div>