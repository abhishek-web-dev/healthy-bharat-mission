<?php 
require_once __DIR__ . '/components/admin-header.php'; 
?>

<style>
.btn-brand {
    background-color: #106e39;
}
.btn-brand:hover {
    background-color: #0b5229;
}
</style>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800" id="page-title">Add New Product</h2>
        <p class="text-sm text-gray-500 mt-1" id="page-subtitle">Create a new product listing.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="products.php" class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-50 transition-colors">
            Cancel
        </a>
        <button type="button" id="save-product-btn" class="btn-brand text-white px-6 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors flex items-center gap-2">
            <i class="fa-regular fa-save"></i> <span id="save-btn-text">Save Product</span>
            <i id="save-btn-spinner" class="fa-solid fa-spinner fa-spin hidden"></i>
        </button>
    </div>
</div>

<div id="error-message" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm font-medium"></div>


<form id="product-form" style="display: flex; gap: 24px; padding-bottom: 3rem;">
    
    <!-- Left Column (Images, Tabs, Attributes, Details) -->
    <div style="flex: 0 0 calc(65% - 12px); max-width: calc(65% - 12px);" class="space-y-6 min-w-0">
        <input type="hidden" id="product-id" value="">
        
        <!-- Images -->
        <div class="bg-white rounded-xl border border-[#106e39] shadow-sm overflow-hidden">
            <div class="p-6 pb-2">
                <h3 class="font-bold text-gray-800">Images</h3>
            </div>
            <div class="p-6 pt-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <!-- Left Column: Main Image Preview -->
                        <div class="border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center bg-gray-50 h-full min-h-[350px] relative overflow-hidden group">
                            <img id="main-image-preview" src="" alt="Preview" class="absolute inset-0 w-full h-full object-contain hidden bg-white">
                            <div id="main-image-placeholder" class="text-center p-8">
                                <i class="fa-regular fa-image text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-400 text-sm mb-2">Main Image Preview</p>
                                <p class="text-[10px] text-gray-400">( First added image will be selected as the main image. )</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Upload Box & Gallery -->
                    <div class="flex flex-col gap-4">
                        <div class="border-2 border-dashed border-gray-200 rounded-xl flex flex-col items-center justify-center p-6 bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer relative" onclick="document.getElementById('product-image-file').click()">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 mb-2"></i>
                            <p class="text-sm font-medium text-gray-600">Click to upload image</p>
                            <p class="text-xs text-gray-400 mt-1">SVG, PNG, JPG or GIF (max. 5MB)</p>
                            <input type="file" id="product-image-file" accept="image/*" multiple class="hidden">
                        </div>
                        
                        <div>
                            <input type="text" id="product-image" class="block w-full px-3 py-2 border border-gray-200 rounded text-xs focus:ring-[#106e39] focus:border-[#106e39]" placeholder="Or enter image URL... (press enter)" onkeydown="if(event.key==='Enter'){event.preventDefault(); window.addImageFromInput(this);}" onclick="event.stopPropagation()">
                        </div>

                        <!-- Gallery Images List -->
                        <div class="grid grid-cols-3 gap-3" id="gallery-preview-container">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Product Data -->
        <style>
            .product-data-container {
                display: flex;
                flex-direction: column;
                min-height: 400px;
            }
            .product-data-sidebar {
                width: 100%;
                flex-shrink: 0;
                background-color: white;
                border-bottom: 1px solid #106e39;
                position: relative;
            }
            .product-data-tabs {
                display: flex;
                flex-direction: row;
                overflow-x: auto;
            }
            @media (min-width: 768px) {
                .product-data-container {
                    flex-direction: row;
                }
                .product-data-sidebar {
                    width: 14rem; /* w-56 */
                    border-bottom: none;
                    border-right: 1px solid #106e39;
                }
                .product-data-tabs {
                    flex-direction: column;
                    overflow-x: visible;
                }
                .tab-btn.active {
                    border-left: 4px solid #106e39 !important;
                    background-color: white !important;
                    color: #106e39 !important;
                    font-weight: bold;
                    /* Overlap the right border of the sidebar container */
                    margin-right: -1px;
                    border-right: 1px solid white;
                    z-index: 10;
                    position: relative;
                }
                .tab-btn:not(.active) {
                    border-left: 4px solid transparent;
                }
            }
            @media (max-width: 767px) {
                .tab-btn.active {
                    border-bottom: 2px solid #106e39 !important;
                    background-color: white !important;
                    color: #106e39 !important;
                    font-weight: bold;
                }
                .tab-btn:not(.active) {
                    border-bottom: 2px solid transparent;
                }
            }
            
            /* Form Field Styling Fallbacks */
            .product-data-container input:not([type="checkbox"]), 
            .product-data-container select, 
            .product-data-container textarea {
                border: 1px solid #e5e7eb; /* tailwind gray-200 */
                border-radius: 0.375rem;
            }
            .product-data-container input:not([type="checkbox"]):focus, 
            .product-data-container select:focus, 
            .product-data-container textarea:focus {
                outline: none;
                border-color: #106e39;
                box-shadow: 0 0 0 1px #106e39;
            }
            .product-data-container .border-gray-100 {
                border-bottom-color: #e6f2eb !important; /* light logo green */
            }
            .product-data-container .border-green-200 {
                border-color: #a3c9b3 !important; /* medium light logo green */
            }
            .product-data-container .bg-gray-50 {
                background-color: #f9fafb !important;
            }
            
            /* Structural Layout Fallbacks */
            .flex-1 {
                flex: 1 1 0% !important;
            }
            @media (min-width: 640px) {
                .sm\:flex-row { flex-direction: row !important; }
                .sm\:items-center { align-items: center !important; }
                .sm\:w-1\/3 { width: 33.333333% !important; }
                .sm\:w-2\/3 { width: 66.666667% !important; }
            }
            @media (min-width: 768px) {
                .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
            }
        </style>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6" style="border: 1px solid #106e39;">
            <!-- Full Width Header -->
            <div class="p-6 pb-4" style="background-color: white; border-bottom: 1px solid #106e39;">
                <h3 class="font-bold text-gray-800 text-sm">Main Product Data</h3>
            </div>
            
            <div class="product-data-container">
                <!-- Sidebar Tabs -->
                <div class="product-data-sidebar">
                    <div class="product-data-tabs hide-scrollbar" id="product-data-tabs">
                        <button type="button" class="tab-btn active text-left px-5 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full flex items-center gap-3 whitespace-nowrap" data-target="tab-general">
                            <i class="fa-solid fa-wrench w-4 text-center"></i> General
                        </button>
                        <button type="button" class="tab-btn text-left px-5 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full flex items-center gap-3 whitespace-nowrap" data-target="tab-description">
                            <i class="fa-regular fa-file-lines w-4 text-center"></i> Description
                        </button>
                        <button type="button" class="tab-btn text-left px-5 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full flex items-center gap-3 whitespace-nowrap" data-target="tab-ingredients">
                            <i class="fa-solid fa-list-ul w-4 text-center"></i> Ingredients
                        </button>
                        <button type="button" class="tab-btn text-left px-5 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full flex items-center gap-3 whitespace-nowrap" data-target="tab-nutrition">
                            <i class="fa-solid fa-apple-whole w-4 text-center"></i> Nutritional Info
                        </button>
                        <button type="button" class="tab-btn text-left px-5 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full flex items-center gap-3 whitespace-nowrap" data-target="tab-how-to-use">
                            <i class="fa-solid fa-book-open w-4 text-center"></i> How to Use
                        </button>
                    </div>
                </div>
                
                <!-- Tab Content -->
                <div class="p-8 flex-1 bg-white">
                <!-- General Tab -->
                <div id="tab-general" class="tab-pane">
                    <div class="space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700">Regular Price (₹) *</label>
                            <div class="w-full sm:w-2/3">
                                <input type="number" step="0.01" min="0" id="product-price" required class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700">Display Price (MRP ₹)</label>
                            <div class="w-full sm:w-2/3">
                                <input type="number" step="0.01" min="0" id="product-mrp" class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700">Public Sale %</label>
                            <div class="w-full sm:w-2/3 flex items-center gap-2">
                                <input type="number" value="0" class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                                <div class="bg-gray-50 border border-green-200 px-3 py-2 rounded text-sm text-gray-500 font-bold">%</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700">
                                Product Type<br>
                                <span class="text-[10px] text-gray-400 font-normal">For tax calculation</span>
                            </label>
                            <div class="w-full sm:w-2/3">
                                <select id="product-type" class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                                    <option value="">Select Product Type</option>
                                    <option value="physical">Physical Product</option>
                                    <option value="digital">Digital Product</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="digital-asset-section" class="hidden flex-col sm:flex-row sm:items-start gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700 mt-2">
                                Digital File
                                <span class="block text-[10px] text-gray-400 font-normal">PDF, ZIP, DOC, XLS (Max: 100MB)</span>
                            </label>
                            <div class="w-full sm:w-2/3">
                                <div id="current-digital-file-container" class="hidden mb-2 p-2 bg-green-50 rounded text-sm text-[#106e39] flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                        <span id="current-digital-file-name" class="font-bold"></span>
                                    </div>
                                </div>
                                <input type="file" id="digital-file" accept=".pdf,.zip,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.epub" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#106e39] hover:file:bg-green-100">
                                <p class="text-xs text-gray-500 mt-1">Leave empty to keep existing file (when editing).</p>
                            </div>
                        </div>
                        
                        <div class="pb-4 border-b border-gray-100">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Note</label>
                            <textarea id="purchase-note" rows="3" class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm" placeholder="Enter an optional note to send the customer after purchase."></textarea>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700">Enable reviews</label>
                            <div class="w-full sm:w-2/3">
                                <input type="checkbox" id="enable-reviews" checked class="w-5 h-5 text-[#106e39] bg-white border-green-300 rounded focus:ring-[#106e39]">
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700">SKU</label>
                            <div class="w-full sm:w-2/3">
                                <input type="text" id="product-sku" placeholder="Stock Keeping Unit" class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-start gap-2 pb-4 border-b border-gray-100">
                            <label class="w-full sm:w-1/3 text-sm font-medium text-gray-700 mt-2">Quantity</label>
                            <div class="w-full sm:w-2/3">
                                <input type="number" min="0" id="product-stock" value="0" class="block w-full px-3 py-2 border border-green-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                            </div>
                        </div>
                    </div> <!-- End space-y-6 -->
                </div> <!-- End tab-general -->
                <!-- Tab Panes removed -->
                
                <div id="tab-description" class="tab-pane hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea id="product-description" rows="10" class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm custom-scrollbar" placeholder="Enter product description..."></textarea>
                </div>
                <div id="tab-ingredients" class="tab-pane hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ingredients</label>
                    <textarea id="product-ingredients" rows="10" class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm custom-scrollbar" placeholder="Enter ingredients list..."></textarea>
                </div>
                <div id="tab-nutrition" class="tab-pane hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nutritional Information</label>
                    <textarea id="product-nutritional-info" rows="10" class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm custom-scrollbar" placeholder="Enter nutritional info..."></textarea>
                </div>
                <div id="tab-how-to-use" class="tab-pane hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">How to Use</label>
                    <textarea id="product-how-to-use" rows="10" class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm custom-scrollbar" placeholder="Instructions on how to use..."></textarea>
                </div>

            </div>
            
        </div>
        </div> <!-- End Main Product Data -->
    
    <!-- Attributes (Variants) -->
        <div class="bg-white rounded-xl border border-[#106e39] shadow-sm overflow-hidden">
            <div class="p-6 pb-2 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Attributes (Variants)</h3>
                <button type="button" id="add-attribute-btn" class="text-[#106e39] text-xs font-bold hover:underline">
                    + Add Attribute
                </button>
            </div>
            <div class="p-6 pt-2" id="attributes-container">
                <p class="text-sm text-gray-500 italic" id="no-attributes-msg">No attributes added. Add attributes for size, flavor, color variations.</p>
            </div>
        </div>
        
        <!-- Key Details -->
        <div class="bg-white rounded-xl border border-[#106e39] shadow-sm overflow-hidden">
            <div class="p-6 pb-2">
                <h3 class="font-bold text-gray-800">Key Details</h3>
            </div>
            <div class="p-6 pt-2">
                <p class="text-sm text-gray-500 mb-2">Enter each detail on a new line (e.g. features, materials, warnings).</p>
                <textarea rows="4" class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm custom-scrollbar" placeholder="e.g. Made with 100% organic cotton&#10;Machine washable&#10;Made in USA"></textarea>
            </div>
        </div>
    </div>

    <!-- Right Column (Basic Info, Organization, Visibility) -->
    <div style="flex: 1; min-width: 0;" class="space-y-6">
        
        <!-- Basic Information -->
        <div class="bg-white rounded-xl border border-[#106e39] shadow-sm overflow-hidden">
            <div class="p-6 pb-2">
                <h3 class="font-bold text-gray-800">Basic Information</h3>
            </div>
            <div class="p-6 pt-2 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" id="product-name" required class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Slug</label>
                    <input type="text" id="product-slug" required class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm" placeholder="e.g., Hersheys-chocolate-bar">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Status</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="product-status" value="0" class="w-4 h-4 text-[#106e39] focus:ring-[#106e39] border-gray-300">
                            <span class="text-sm text-gray-700">Draft</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="product-status" value="1" checked class="w-4 h-4 text-[#106e39] focus:ring-[#106e39] border-gray-300">
                            <span class="text-sm text-gray-700">Published</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="product-status" value="-1" class="w-4 h-4 text-[#106e39] focus:ring-[#106e39] border-gray-300">
                            <span class="text-sm text-gray-700">Archived</span>
                        </label>
                    </div>
                </div>
                
                
            </div>
        </div>
        
        <!-- Organization -->
        <div class="bg-white rounded-xl border border-[#106e39] shadow-sm overflow-hidden">
            <div class="p-6 pb-2">
                <h3 class="font-bold text-gray-800">Organization</h3>
            </div>
            <div class="p-6 pt-2 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Category</label>
                        <select id="product-category" required class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                            <!-- Populated by JS -->
                        </select>
                    </div>

                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Flags</h4>
                    <div class="flex items-center gap-4 flex-wrap">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-[#106e39] border-gray-300 rounded focus:ring-[#106e39]">
                            <span class="text-sm text-gray-700">Featured Product</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-[#106e39] border-gray-300 rounded focus:ring-[#106e39]">
                            <span class="text-sm text-gray-700">Is Food Item</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-[#106e39] border-gray-300 rounded focus:ring-[#106e39]">
                            <span class="text-sm text-gray-700">Is Fragile</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Visibility</h4>
                    <div class="flex items-center gap-4 flex-wrap">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-[#106e39] border-gray-300 rounded focus:ring-[#106e39]">
                            <span class="text-sm text-gray-700">Public</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-[#106e39] border-gray-300 rounded focus:ring-[#106e39]">
                            <span class="text-sm text-gray-700">Internal</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('product-form');
    const errorMsg = document.getElementById('error-message');
    const submitBtn = document.getElementById('save-product-btn');
    const btnText = document.getElementById('save-btn-text');
    const btnSpinner = document.getElementById('save-btn-spinner');
    
    // Tab switching logic
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'text-[#106e39]', 'text-gray-900', 'bg-white');
                b.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
                if(window.innerWidth >= 768) {
                    b.classList.remove('border-l-4', 'border-[#106e39]');
                    b.classList.add('border-transparent');
                } else {
                    b.classList.remove('border-b-2', 'border-[#106e39]');
                    b.classList.add('border-transparent');
                }
            });
            tabPanes.forEach(p => p.classList.add('hidden'));
            
            // Activate clicked
            btn.classList.add('active', 'text-[#106e39]', 'bg-white');
            btn.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
            if(window.innerWidth >= 768) {
                btn.classList.add('border-l-4', 'border-[#106e39]');
                btn.classList.remove('border-transparent');
            } else {
                btn.classList.add('border-b-2', 'border-[#106e39]');
                btn.classList.remove('border-transparent');
            }
            
            // Show target pane
            const target = btn.getAttribute('data-target');
            document.getElementById(target).classList.remove('hidden');
        });
    });

    // Attributes Logic
    const addAttributeBtn = document.getElementById('add-attribute-btn');
    const attributesContainer = document.getElementById('attributes-container');
    const noAttributesMsg = document.getElementById('no-attributes-msg');

    if (addAttributeBtn) {
        addAttributeBtn.addEventListener('click', () => {
            if (noAttributesMsg) {
                noAttributesMsg.style.display = 'none';
            }
            
            const row = document.createElement('div');
            row.className = 'flex items-center gap-3 mb-3 attribute-row';
            row.innerHTML = `
                <input type="text" placeholder="Name (e.g. Size)" class="block w-1/3 px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                <input type="text" placeholder="Values (comma separated)" class="block w-full px-3 py-2 border border-gray-200 rounded focus:ring-[#106e39] focus:border-[#106e39] sm:text-sm">
                <button type="button" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors" onclick="this.closest('.attribute-row').remove(); if(document.querySelectorAll('.attribute-row').length === 0 && document.getElementById('no-attributes-msg')) document.getElementById('no-attributes-msg').style.display = 'block';">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            attributesContainer.appendChild(row);
        });
    }

    // Auto-generate slug from name
    document.getElementById('product-name').addEventListener('input', function(e) {
        if (!document.getElementById('product-id').value) { // Only auto-slug for new products
            const slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            document.getElementById('product-slug').value = slug;
        }
    });

    // Multiple Images Logic
    let uploadedImages = [];
    const galleryContainer = document.getElementById('gallery-preview-container');
    const mainPreview = document.getElementById('main-image-preview');
    const mainPlaceholder = document.getElementById('main-image-placeholder');
    const fileInput = document.getElementById('product-image-file');

    function updateImageGallery() {
        if (uploadedImages.length > 0) {
            mainPreview.src = uploadedImages[0];
            mainPreview.classList.remove('hidden');
            mainPlaceholder.classList.add('hidden');
        } else {
            mainPreview.classList.add('hidden');
            mainPlaceholder.classList.remove('hidden');
        }

        galleryContainer.innerHTML = '';
        for (let i = 0; i < uploadedImages.length; i++) {
            const isPrimary = i === 0;
            const primaryBadge = isPrimary ? `<span class="absolute top-1 left-1 bg-[#106e39] text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm z-10">Primary</span>` : '';
            
            galleryContainer.innerHTML += `
                <div class="border border-green-200 rounded-lg aspect-square bg-gray-50 flex items-center justify-center overflow-hidden relative min-w-0 cursor-pointer shadow-sm hover:shadow-md transition-shadow">
                    ${primaryBadge}
                    <img src="${uploadedImages[i]}" class="absolute inset-0 w-full h-full object-cover">
                    <button type="button" class="absolute top-1 right-1 bg-white rounded-full w-5 h-5 flex items-center justify-center shadow hover:bg-gray-100 z-10" onclick="removeImage(${i}); event.stopPropagation();">
                        <i class="fa-solid fa-times text-[10px] text-red-500"></i>
                    </button>
                </div>`;
        }
    }

    window.removeImage = function(index) {
        uploadedImages.splice(index, 1);
        updateImageGallery();
    };

    window.addImageFromInput = function(el) {
        const url = el.value.trim();
        if (url) {
            uploadedImages.push(url);
            el.value = '';
            updateImageGallery();
        }
    };

    fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
            for (let i = 0; i < e.target.files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadedImages.push(e.target.result);
                    updateImageGallery();
                }
                reader.readAsDataURL(e.target.files[i]);
            }
        }
        fileInput.value = ''; // reset so same files can be selected again
    });

    // Load Categories and edit data
    async function init() {
        try {
            // Fetch categories
            const catRes = await window.HBM_API.request('/product-categories');
            if (catRes.data) {
                const catOptions = catRes.data.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
                document.getElementById('product-category').innerHTML = `<option value="">Select a category</option>` + catOptions;
            }

            // Check if editing
            const urlParams = new URLSearchParams(window.location.search);
            const editId = urlParams.get('id') || urlParams.get('pid');
            
            if (editId) {
                document.getElementById('page-title').textContent = 'Edit Product';
                document.getElementById('page-subtitle').textContent = 'Update product details.';
                
                // Fetch product details
                // Since the backend only has getAllProducts (list), we can fetch all and find it,
                // or if there's a specific GET endpoint we can use it. We'll use the list for now.
                const res = await window.HBM_API.request('/admin/products');
                
                // The API might return the array directly, in a `products` key, or in a paginated `data` key
                let productList = [];
                if (res.data && res.data.products) {
                    productList = res.data.products;
                } else if (res.data && res.data.data) {
                    productList = res.data.data;
                } else if (res.data && Array.isArray(res.data)) {
                    productList = res.data;
                } else if (Array.isArray(res.data)) {
                    productList = res.data;
                }

                if (productList && productList.length > 0) {
                    const product = productList.find(p => p.id == editId);
                    if (product) {
                        document.getElementById('product-id').value = product.id;
                        document.getElementById('product-name').value = product.name;
                        document.getElementById('product-slug').value = product.slug;
                        document.getElementById('product-category').value = product.category_id;
                        document.getElementById('product-description').value = product.description || '';
                        document.getElementById('product-ingredients').value = product.ingredients || '';
                        document.getElementById('product-nutritional-info').value = product.nutritional_info || '';
                        document.getElementById('product-how-to-use').value = product.how_to_use || '';
                        document.getElementById('product-price').value = product.price;
                        document.getElementById('product-mrp').value = product.mrp || '';
                        document.getElementById('product-stock').value = product.stock;
                        
                        // Load all images if available
                        if (product.images && product.images.length > 0) {
                            uploadedImages = product.images.map(img => typeof img === 'string' ? img : (img.image_url || img));
                            updateImageGallery();
                        } else if (product.thumbnail_url) {
                            uploadedImages.push(product.thumbnail_url);
                            updateImageGallery();
                        }

                        // Status radio
                        const statusRadios = document.getElementsByName('product-status');
                        for (let radio of statusRadios) {
                            if (radio.value == product.is_active) {
                                radio.checked = true;
                            }
                        }

                        // Digital product
                        if (product.is_digital) {
                            document.getElementById('product-type').value = 'digital';
                            document.getElementById('digital-asset-section').classList.remove('hidden');
                            document.getElementById('digital-asset-section').style.display = 'flex';
                            if (product.digital_file_name) {
                                document.getElementById('current-digital-file-container').classList.remove('hidden');
                                document.getElementById('current-digital-file-name').textContent = product.digital_file_name;
                            }
                        }
                    } else {
                        throw new Error('Product not found.');
                    }
                }
            }

        } catch (error) {
            console.error("Initialization failed", error);
            errorMsg.textContent = 'Failed to load necessary data.';
            errorMsg.classList.remove('hidden');
        }
    }

    // Save product
    submitBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        
        // Basic validation
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const id = document.getElementById('product-id').value;
        const statusVal = document.querySelector('input[name="product-status"]:checked').value;
        
        const payload = {
            name: document.getElementById('product-name').value.trim(),
            slug: document.getElementById('product-slug').value.trim(),
            category_id: document.getElementById('product-category').value,
            description: document.getElementById('product-description').value.trim(),
            ingredients: document.getElementById('product-ingredients').value.trim(),
            nutritional_info: document.getElementById('product-nutritional-info').value.trim(),
            how_to_use: document.getElementById('product-how-to-use').value.trim(),
            price: document.getElementById('product-price').value,
            mrp: document.getElementById('product-mrp').value ? document.getElementById('product-mrp').value : null,
            stock: document.getElementById('product-stock').value,
            images: uploadedImages, // Send all images to backend
            thumbnail_url: uploadedImages.length > 0 ? uploadedImages[0] : '',
            is_active: statusVal,
            is_digital: document.getElementById('product-type').value === 'digital' ? 1 : 0,
        };
        
        submitBtn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');
        errorMsg.classList.add('hidden');
        
        let submitData = payload;
        
        // If digital product is selected, try to send as FormData so the file uploads correctly
        if (payload.is_digital) {
            const formData = new FormData();
            formData.append('payload', JSON.stringify(payload));
            const digitalFile = document.getElementById('digital-file').files[0];
            if (digitalFile) {
                formData.append('digital_file', digitalFile);
            } else if (!id && !document.getElementById('current-digital-file-name').textContent) {
                errorMsg.textContent = 'A digital file is required for a new digital product.';
                errorMsg.classList.remove('hidden');
                submitBtn.disabled = false;
                btnText.textContent = 'Save Product';
                btnSpinner.classList.add('hidden');
                return;
            }
            submitData = formData;
        }

        try {
            if (id) {
                await window.HBM_API.request(`/admin/products/${id}`, 'POST', submitData);
            } else {
                await window.HBM_API.request('/admin/products', 'POST', submitData);
            }
            
            // Redirect back to list
            window.location.href = 'products.php';
        } catch (err) {
            errorMsg.textContent = err.message || 'An error occurred while saving the product.';
            errorMsg.classList.remove('hidden');
            
            // Scroll to error
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            submitBtn.disabled = false;
            btnText.textContent = 'Save Product';
            btnSpinner.classList.add('hidden');
        }
    });

    init();
    // Product Type Toggle
    document.getElementById('product-type').addEventListener('change', (e) => {
        const digitalSection = document.getElementById('digital-asset-section');
        if (e.target.value === 'digital') {
            digitalSection.classList.remove('hidden');
            digitalSection.style.display = 'flex';
        } else {
            digitalSection.classList.add('hidden');
            digitalSection.style.display = 'none';
        }
    });
});
</script>

<?php require_once __DIR__ . '/components/admin-footer.php'; ?>
