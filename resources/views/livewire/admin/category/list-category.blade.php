<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tên</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($categories as $category)
                    <tr>
                        <td class="text-center">
                            <span>{{ $category->id }}</span>
                        </td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td class="text-center cursor-pointer">
                            <div class="d-flex justify-content-center">
                                <a class="dropdown-item" wire:click="openEditModal({{ $category->id }})" style="width: 20%">
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:key="edit-modal">
        <div class="modal-dialog">
            <form id="formUpdateCategory" wire:submit.prevent="updateCategory" wire:confirm="Xác nhận cập nhập!">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control d-none" type="text" id="id" wire:model="id" />
                        <div class="mb-3">
                            <label class="form-label" for="name">Tên danh mục<span class="required">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" wire:model="name" placeholder="Nhập tên" />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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