<?php
$page_title = "Order Confirmed";
require_once 'includes/header.php';

$order_number = $_GET['id'] ?? '';
$order = db_fetch_one("SELECT * FROM orders WHERE order_number = ?", [$order_number]);

if(!$order) redirect('index.php');
?>
<main class="min-h-screen flex items-center justify-center bg-slate-50 py-20 px-4">
    <div class="max-w-xl w-full text-center">
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-neon-green rounded-full flex items-center justify-center border-[4px] border-black shadow-[8px_8px_0px_0px_#000] animate-bounce">
                <i data-lucide="check" class="w-12 h-12 text-black"></i>
            </div>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-4">Ordered!</h1>
        <p class="text-slate-500 font-bold mb-8 text-lg">Your drip is on the way. Order #<?php echo $order_number; ?></p>
        
        <div class="bg-white p-8 rounded-[32px] border-[3px] border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,0.1)] mb-8">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Total Amount</p>
            <p class="text-4xl font-black"><?php echo format_price($order['total_amount']); ?></p>
        </div>

        <a href="index.php" class="inline-flex items-center gap-2 h-16 px-10 bg-black text-white rounded-2xl font-black uppercase tracking-widest hover:bg-primary transition-all shadow-[6px_6px_0px_0px_#ccfd32]">
            Back to Home
        </a>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>
