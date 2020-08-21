<div class="card card-default">
    <div class="card-header card-header-border-bottom">
        <h2>Product Menus</h2>
    </div>
    <div class="card-body">
        <nav class="nav flex-column">
            <a class="btn btn-info" href="{{ url('admin/products/'. $productID .'/edit') }}">Product Detail</a>
            <br>
            <a class="btn btn-warning" style="color: white" href="{{ url('admin/products/'. $productID .'/images') }}">Product Images</a>
        </nav>
    </div>
</div>
