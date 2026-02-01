<?php
$page_title = "About Us";
require_once 'includes/header.php';
?>

<main class="pt-20">
    <div class="container mx-auto px-4 lg:px-20">
        <!-- Story Section -->
        <div class="flex flex-col lg:flex-row gap-20 items-center mb-32">
            <div class="w-full lg:w-1/2">
                <span class="text-xs font-bold text-primary uppercase tracking-[0.3em] mb-4 inline-block">Our Story</span>
                <h1 class="text-6xl lg:text-8xl font-black tracking-tighter mb-10 leading-none">
                    Crafting <br/>
                    The <span class="text-gradient">Future</span>
                </h1>
                <p class="text-xl text-slate-500 leading-relaxed mb-8">
                    WearKraft was born out of a simple idea: everyone deserves to wear their vision. We've built the most intuitive system to design and order premium custom apparel without the headache of traditional printing services.
                </p>
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-4xl font-black text-slate-900 mb-1">10k+</p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Designs Created</p>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-slate-900 mb-1">4.9/5</p>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Customer Rating</p>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 relative">
                <div class="absolute -top-10 -right-10 w-full h-full border-[3px] border-black rounded-[60px] bg-neon-yellow z-0"></div>
                <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&q=80" 
                     class="relative z-10 w-full h-[600px] object-cover rounded-[60px] border-[3px] border-black shadow-none grayscale hover:grayscale-0 transition-all duration-500" alt="About WearKraft">
            </div>
        </div>

        <!-- Team / Values -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-32">
            <div class="bg-white p-12 rounded-[50px] border-[3px] border-black shadow-[8px_8px_0px_0px_#000] hover:shadow-[12px_12px_0px_0px_#000] hover:-translate-y-1 transition-all">
                <div class="w-16 h-16 bg-white border-[3px] border-black text-black rounded-3xl flex items-center justify-center mb-8 shadow-[4px_4px_0px_0px_#000]">
                    <i data-lucide="zap" class="w-8 h-8 fill-black"></i>
                </div>
                <h3 class="text-2xl font-black mb-4 uppercase tracking-tight">Innovation First</h3>
                <p class="text-slate-500 font-bold leading-relaxed">We constantly update our printing technology (DTG, Vinyl, Embroidery) to ensure the sharpest results.</p>
            </div>
            <div class="bg-neon-green p-12 rounded-[50px] border-[3px] border-black shadow-[8px_8px_0px_0px_#000] hover:shadow-[12px_12px_0px_0px_#000] hover:-translate-y-1 transition-all rotate-1">
                <div class="w-16 h-16 bg-white border-[3px] border-black text-black rounded-3xl flex items-center justify-center mb-8 shadow-[4px_4px_0px_0px_#000]">
                    <i data-lucide="leaf" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-black mb-4 uppercase tracking-tight">Eco Conscious</h3>
                <p class="text-black font-bold leading-relaxed">Most of our apparel is made from 100% organic cotton and we use water-based, eco-friendly inks.</p>
            </div>
            <div class="bg-white p-12 rounded-[50px] border-[3px] border-black shadow-[8px_8px_0px_0px_#000] hover:shadow-[12px_12px_0px_0px_#000] hover:-translate-y-1 transition-all">
                <div class="w-16 h-16 bg-white border-[3px] border-black text-black rounded-3xl flex items-center justify-center mb-8 shadow-[4px_4px_0px_0px_#000]">
                    <i data-lucide="users" class="w-8 h-8 fill-black"></i>
                </div>
                <h3 class="text-2xl font-black mb-4 uppercase tracking-tight">Community Driven</h3>
                <p class="text-slate-500 font-bold leading-relaxed">We support local creators and artists through our creator-affiliate program.</p>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
