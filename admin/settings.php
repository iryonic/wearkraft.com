<?php
require_once 'includes/header.php';

// Handle setting updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['settings'] as $key => $value) {
        db_query("UPDATE settings SET setting_value = ? WHERE setting_key = ?", [$value, $key]);
    }
    echo "<script>alert('Settings updated successfully!');</script>";
}

$all_settings = db_fetch_all("SELECT * FROM settings");
?>

<div class="mb-10">
    <h1 class="text-3xl font-black tracking-tight mb-2">System Preferences</h1>
    <p class="text-slate-500">Global configuration and branding controls.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-2">
        <form action="settings.php" method="POST" class="space-y-8">
            <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100 space-y-8">
                <h3 class="text-xl font-bold flex items-center gap-3">
                    <i data-lucide="monitor" class="w-5 h-5 text-primary"></i>
                    General Settings
                </h3>

                <?php foreach($all_settings as $s): ?>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-3"><?php echo str_replace('_', ' ', $s['setting_key']); ?></label>
                    <?php if($s['setting_key'] === 'maintenance_mode'): ?>
                    <select name="settings[<?php echo $s['setting_key']; ?>]" class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-all font-medium">
                        <option value="off" <?php echo $s['setting_value'] === 'off' ? 'selected' : ''; ?>>OFF (Live)</option>
                        <option value="on" <?php echo $s['setting_value'] === 'on' ? 'selected' : ''; ?>>ON (Maintenance)</option>
                    </select>
                    <?php else: ?>
                    <input type="text" name="settings[<?php echo $s['setting_key']; ?>]" value="<?php echo $s['setting_value']; ?>" 
                           class="w-full bg-slate-50 border border-slate-100 h-14 rounded-2xl px-6 focus:outline-none focus:border-primary transition-all font-medium">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>

                <div class="pt-4">
                    <button type="submit" class="px-12 h-14 bg-black text-white rounded-2xl font-bold hover:bg-slate-800 transition-all flex items-center gap-3 shadow-xl shadow-black/10">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Side help/info -->
    <div class="space-y-8">
        <div class="bg-blue-600 rounded-[40px] p-10 text-white relative overflow-hidden">
             <div class="relative z-10">
                <h3 class="text-xl font-bold mb-4">Quick Tip</h3>
                <p class="text-blue-100 text-sm leading-relaxed mb-6">Changing the 'maintenance_mode' to ON will prevent all non-admin users from accessing the frontend.</p>
             </div>
             <i data-lucide="info" class="absolute -bottom-4 -right-4 w-24 h-24 opacity-20"></i>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
