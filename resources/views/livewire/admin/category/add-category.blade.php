<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="formAddCategory" wire:submit.prevent="addCategory">
                        <div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="category_type">Chọn loại danh mục <span class="required">*</span></label>
                                <select class="form-select" id="category_type" wire:model="category_type" wire:change="updateCategorySelect">
                                    <option value="category">Thêm danh mục</option>
                                    <option value="product_category">Thêm danh mục sản phẩm</option>
                                    <option value="both">Thêm cả 2 danh mục</option>
                                </select>
                            </div>

                            <!-- Danh mục -->
                            @if ($selected_value != 'product_category')
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="category">Danh mục <span class="required">*</span></label>
                                <input class="form-control @error('category') is-invalid @enderror" type="text" id="category" wire:model="category" placeholder="Nhập tên danh mục chính" />
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <!-- Select danh mục -->
                            @if ($selected_value == 'product_category')
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="select_category">Danh mục <span class="required">*</span></label>
                                <select class="form-select" id="select_category" wire:model="select_category">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('select_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <!-- Danh mục sản phẩm -->
                            @if ($selected_value != 'category')
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="product_category">Danh mục sản phẩm <span class="required">*</span></label>
                                <input class="form-control @error('product_category') is-invalid @enderror" type="text" id="product_category" wire:model="product_category" placeholder="Nhập tên danh mục phụ" />
                                @error('product_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                        </div>

                        <button type="submit" class="btn btn-primary">Thêm</button>
                        @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Basic Layout -->

</div>
<!-- / Content -->