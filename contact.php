<?php
$page_title = "Contact Us";
require_once 'includes/header.php';
?>

<main class="pt-20">
    <div class="container mx-auto px-4 lg:px-20">
        <div class="flex flex-col lg:flex-row gap-20">
            <!-- Left Info -->
            <div class="w-full lg:w-1/3">
                <h1 class="text-6xl font-black tracking-tighter mb-10">Get in <br/><span class="text-gradient">Touch</span></h1>
                <p class="text-slate-500 mb-12">Have a bulky project or just want to say hi? We're here to help you bring your ideas to life.</p>
                
                <div class="space-y-10">
                    <div class="flex items-start gap-6">
                        <div class="icon-box w-14 h-14 bg-white text-black rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="mail" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email Us</p>
                            <p class="font-bold text-lg">hello@wearkraft.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="icon-box w-14 h-14 bg-white text-black rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="phone" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Call Us</p>
                            <p class="font-bold text-lg">+91 98765 43210</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="icon-box w-14 h-14 bg-white text-black rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Our Studio</p>
                            <p class="font-bold text-lg">Indiranagar, Bangalore, IN</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form -->
            <div class="w-full lg:w-2/3">
                <form class="glass p-12 lg:p-16 rounded-[40px] space-y-8 relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-neon-yellow border-[3px] border-black rounded-full z-0"></div>
                    <div class="relative z-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-3">Full Name</label>
                            <input type="text" class="input-chunky w-full bg-slate-50 border h-16 rounded-2xl px-8 focus:outline-none focus:border-black transition-all font-bold text-lg placeholder-slate-400" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-3">Email Address</label>
                            <input type="email" class="input-chunky w-full bg-slate-50 border h-16 rounded-2xl px-8 focus:outline-none focus:border-black transition-all font-bold text-lg placeholder-slate-400" placeholder="john@example.com">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-3">Subject</label>
                        <select class="input-chunky w-full bg-slate-50 border h-16 rounded-2xl px-8 focus:outline-none focus:border-black transition-all font-bold text-lg">
                            <option>General Inquiry</option>
                            <option>Bulk Order Request</option>
                            <option>Partnership</option>
                            <option>Technical Support</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-3">Your Message</label>
                        <textarea class="input-chunky w-full bg-slate-50 border h-48 rounded-2xl p-8 focus:outline-none focus:border-black transition-all font-bold text-lg resize-none placeholder-slate-400" placeholder="Tell us more about your vision..."></textarea>
                    </div>
                    <button class="w-full py-6 bg-black text-white rounded-2xl font-black text-xl hover:bg-slate-800 transition-all transform active:scale-95 shadow-[6px_6px_0px_0px_#FF6B00] border-[3px] border-black flex items-center justify-center gap-3">
                        Send Message
                        <i data-lucide="send" class="w-6 h-6"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
    /* Unique Chunky Styles for Contact Page */
    .glass {
        background: #fff; /* Reset glass */
        border: 3px solid #000 !important;
        box-shadow: 12px 12px 0px 0px #000 !important;
    }
    .input-chunky {
        border: 3px solid #000 !important;
        box-shadow: 4px 4px 0px 0px #e2e8f0;
        transition: all 0.3s ease;
    }
    .input-chunky:focus {
        box-shadow: 6px 6px 0px 0px #000;
        background-color: #FEF3C7; /* yellow-50 */
    }
    .icon-box {
        border: 3px solid #000;
        box-shadow: 4px 4px 0px 0px #000;
        transition: transform 0.2s;
    }
    .icon-box:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0px 0px #000;
    }
</style>

<?php require_once 'includes/footer.php'; ?>
