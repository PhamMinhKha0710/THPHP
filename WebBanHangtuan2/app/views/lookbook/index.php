<?php
require_once 'app/views/shares/header.php';
?>

<style>
    .lookbook-card .lookbook-image {
        position: relative;
        overflow: hidden;
    }
    
    .lookbook-overlay {
        background: rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease;
    }
    
    .lookbook-card:hover .lookbook-overlay {
        background: rgba(0, 0, 0, 0.7);
    }
</style>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold mb-3">LOOKBOOK</h1>
            <p class="lead text-muted">Khám phá các phong cách thời trang mới nhất của chúng tôi</p>
        </div>
    </div>
    
    <div class="row g-4">
        <?php foreach ($lookbooks as $lookbook): ?>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm lookbook-card">
                <div class="lookbook-image">
                    <img src="<?php echo htmlspecialchars($lookbook['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($lookbook['title']); ?>" style="height: 300px; object-fit: cover;">
                    <div class="lookbook-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                        <a href="/THPHP/WebBanHangtuan2/Lookbook/show/<?php echo $lookbook['id']; ?>" class="btn btn-outline-light">Xem chi tiết</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="small text-muted mb-2"><?php echo date('d/m/Y', strtotime($lookbook['date'])); ?></div>
                    <h5 class="card-title"><?php echo htmlspecialchars($lookbook['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($lookbook['description']); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any interactive elements if needed
});
</script>

<?php
require_once 'app/views/shares/footer.php';
?> 