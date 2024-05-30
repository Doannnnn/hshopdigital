<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <div class="mb-3 col-md-3">
        <select class="form-select" wire:model="category_type" wire:change="updateSelectType">
            <option value="child">Danh mục sản phẩm</option>
            <option value="parent">Danh mục</option>
        </select>
    </div>

    <!-- Basic Bootstrap Table -->
    @if ($category_type == 'child')
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Danh mục sản phẩm</th>
                        <th class="text-center">Danh mục</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($product_categories as $category)
                    <tr>
                        <td class="text-center">
                            <span>{{ $category->id }}</span>
                        </td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center">
                            @if ($category->parent)
                            {{ $category->parent->name }}
                            @else
                            None
                            @endif
                        </td>
                        <td class="text-center cursor-pointer">
                            <div class="d-flex justify-content-center">
                                <a class="dropdown-item" wire:click="openEditModal({{ $category->id }}, 'product_category')" style="width: 20%">
                                    <i class="bx bx-edit-alt me-1"></i> Sửa
                                </a>
                                <a class="dropdown-item" wire:click="deleteCategory({{ $category->id }})" style="width: 20%" wire:confirm="Xác nhận xoá danh mục?">
                                    <i class="bx bx-trash me-1"></i> Xoá
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $product_categories->links() }}
            </div>
        </div>
    </div>
    @endif

    @if ($category_type == 'parent')
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Danh mục</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($listCategory as $category)
                    <tr>
                        <td class="text-center">
                            <span>{{ $category->id }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $category->name }}</span>
                        </td>
                        <td class="text-center cursor-pointer">
                            <div class="d-flex justify-content-center">
                                <a class="dropdown-item" wire:click="openEditModal({{ $category->id }}, 'category')" style="width: 20%">
                                    <i class="bx bx-edit-alt me-1"></i> Sửa
                                </a>
                                <a class="dropdown-item" wire:click="deleteCategory({{ $category->id }})" style="width: 20%" wire:confirm="Xác nhận xoá danh mục?">
                                    <i class="bx bx-trash me-1"></i> Xoá
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $listCategory->links() }}
            </div>
        </div>
    </div>
    @endif
    <!--/ Basic Bootstrap Table -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:key="edit-modal">
        <div class="modal-dialog">
            <form id="formUpdateCategory" wire:submit.prevent="updateCategory">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control d-none" type="text" id="id" wire:model="id" />
                        @if($category_type == 'child')
                        <div class="mb-3">
                            <label class="form-label" for="category">Danh mục <span class="required">*</span></label>
                            <select class="form-select" id="category" wire:model="category">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="product_category">Danh mục sản phẩm <span class="required">*</span></label>
                            <input class="form-control @error('product_category') is-invalid @enderror" type="text" id="product_category" wire:model="product_category" placeholder="Nhập tên" />
                            @error('product_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        @if($category_type == 'parent')
                        <div class="mb-3">
                            <label class="form-label" for="category">Danh mục <span class="required">*</span></label>
                            <input class="form-control @error('category') is-invalid @enderror" type="text" id="category" wire:model="category" placeholder="Nhập tên" />
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- / Content -->