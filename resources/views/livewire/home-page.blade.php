<div>
   {{-- Hero section start --}}

    <main class="flex-1">
        <div class="px-40 flex  justify-center py-5 mt-0 pt-0">
            <div class="layout-content-container flex flex-col max-w-none flex-1">
                <div class="@container">
                    <div class="@[480px]:p-4">
                        <div class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-lg items-start justify-start px-4 pb-10 @[480px]:px-10"
                            style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url({{ asset('storage/images/bg.jpg')}});'>
    
                            <div class="flex flex-col gap-2 text-left pt-20 pb-10">
                                <h1
                                    class="mt-0 pt-0 text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
                                    Willkommen bei complete it <br> und compservice
                                </h1>
                                <h2
                                    class="pt-10 text-white text-xl font-normal leading-normal  @[480px]:font-normal @[480px]:leading-normal max-w-[900px]">
                                    Ihr Spezialist für Laptops, Computer und Gaming-PCs. <br> Wir bieten auch Reparaturen
                                    und bauen individuelle <br>
                                    Gaming-Systeme.
                                </h2>
                            </div>
                            <button
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-green-500 hover:bg-[#ff6600] text-white text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em]">
                                <span class="truncate">Jetzt einkaufen</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
    
    
        >
    
    
    
    

   {{-- Hero section end --}}
  {{-- Brand section start  --}}
<section class="py-20">
    <div class="max-w-xl mx-auto">
        <div class="text-center ">
            <div class="relative flex flex-col items-center">
                <h1 class="text-5xl font-bold dark:text-gray-200"> Browse Popular<span class="text-blue-500"> Brands
                    </span> </h1>
                <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                    <div class="flex-1 h-2 bg-blue-200">
                    </div>
                    <div class="flex-1 h-2 bg-blue-400">
                    </div>
                    <div class="flex-1 h-2 bg-blue-600">
                    </div>
                </div>
            </div>
            <p class="mb-12 text-base text-center text-gray-500">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus magni eius eaque?
                Pariatur
                numquam, odio quod nobis ipsum ex cupiditate?
            </p>
        </div>
    </div>
    <div class="justify-center max-w-6xl px-4 py-4 mx-auto lg:py-0">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 md:grid-cols-2">

@foreach ($brands as $brand)

    <div class="bg-white rounded-lg shadow-md dark:bg-gray-800" wire:key="{{ $brand->id}}">
        <a href="/products?selected_brands[0]={{$brand->id}}" class="">
            <img src="{{\App\Helpers\ImageHelper::getBrandImage($brand)}}" alt="{{$brand->name}}"
                class="object-cover w-full h-64 rounded-t-lg">
        </a>
        <div class="p-5 text-center">
            <a href="" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-300">
               {{$brand->name}}
            </a>
        </div>
    </div>

@endforeach

           


        </div>
    </div>
    </section>
  {{-- Brand section end  --}}

  {{-- category section start  --}}
<div class="bg-orange-200 py-20">
    <div class="max-w-xl mx-auto">
        <div class="text-center ">
            <div class="relative flex flex-col items-center">
                <h1 class="text-5xl font-bold dark:text-gray-200"> Browse <span class="text-blue-500"> Categories
                    </span> </h1>
                <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                    <div class="flex-1 h-2 bg-blue-200">
                    </div>
                    <div class="flex-1 h-2 bg-blue-400">
                    </div>
                    <div class="flex-1 h-2 bg-blue-600">
                    </div>
                </div>
            </div>
            <p class="mb-12 text-base text-center text-gray-500">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus magni eius eaque?
                Pariatur
                numquam, odio quod nobis ipsum ex cupiditate?
            </p>
        </div>
    </div>

    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">

@foreach ($categories as $category)

    <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600
      " href="/products?selected_category[0]={{$category->id}}"  wire:key="{{ $category->id}}">
        <div class="p-4 md:p-5 ">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img class="h-[2.375rem] w-[2.375rem] rounded-full"
                        src="{{\App\Helpers\ImageHelper::getCategoryImage($category)}}"
                        alt="{{$category->name}}">
                    <div class="ms-3">
                        <h3
                            class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200">
                            {{$category->name}}
                        </h3>
                    </div>
                </div>
                <div class="ps-3">
                    <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </div>
            </div>
        </div>
    </a>

@endforeach

           

        

        </div>
    </div>

    </div>
  {{-- category section end  --}}




  {{-- unsere firma start --}}
<section>


    <div class="row why-cics__row">
        <div class="col col-6 why-cics__left">
            <div class="col why-cics__left">
                <h1>WARUM SOLLTEN SIE SICH
                    IM JAHR 2025 <br>FÜR IHRE LAPTOP-REPARATUR FÜR CICS ENTSCHEIDEN?</h1>
                <p class="why-cics__desc">
                    Das CICS Computer Service Centre ist für seinen erstklassigen und zuverlässigen
                    Laptop-Reparaturservice in Singapur bekannt. Hier erfahren Sie, warum es zu den besten
                    Laptop-Reparaturwerkstätten des Landes zählt:
                </p>
                <ul class="why-cics__list">
                    <li>
                        <button class="accordion-btn">
                            <span>Handel mit PCs und Laptops:</span>
                            <span class="plus">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>

                                Verkauf von neuen und gebrauchten PCs und Laptops, einschließlich dem individuellen
                                Zusammenbau von Gaming-PCs nach Kundenwunsch. Kunden profitieren von maßgeschneiderten
                                Systemen, die exakt auf ihre Anforderungen und Spiele abgestimmt sind. Die Auswahl und
                                Kombination der Komponenten erfolgt nach den persönlichen Wünschen, um maximale
                                Performance und Zuverlässigkeit zu gewährleisten
                            </p>
                        </div>
                    </li>
                    <li>
                        <button class="accordion-btn">
                            <span>Handel mit PC- und Laptop-Teilen:
                            </span>
                            <span class="plus">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>

                                Vertrieb von Komponenten, Zubehör und Ersatzteilen für Computer und Laptops. Kunden
                                können aus einer breiten Auswahl aktueller und hochwertiger Hardware wählen, um ihre
                                Geräte individuell aufzurüsten oder zu reparieren
                            </p>
                        </div>
                    </li>
                    <li>
                        <button class="accordion-btn">
                            <span>Reparaturservice:</span>
                            <span class="plus">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>

                                Durchführung von Reparaturen und Wartungsarbeiten an PCs und Laptops, einschließlich
                                Fehlerdiagnose, Austausch defekter Bauteile und Systemoptimierung
                            </p>
                        </div>
                    </li>
                    <li>
                        <button class="accordion-btn">
                            <span>IT-Administration und Support:</span>
                            <span class="plus">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                Unterstützung von Unternehmen und Privatpersonen in allen IT-Fragen, insbesondere bei
                                der Installation, Wartung und Verbesserung von IT-Systemen. Das Angebot umfasst
                                IT-Beratung, Einrichtung und Betreuung von Netzwerken, IT-Sicherheit, Backup-Lösungen
                                sowie fortlaufenden Support zur Sicherstellung eines reibungslosen IT-Betriebs
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col col-6 why-cics__right">
            <img src="{{asset('images-/firma.jpeg')}}" alt="cics Bild" />
        </div>
    </div>

</section>

<style>
    /* ============================= unsere firma ====================== */
/*  */
.why-cics {
	width: 100%;
	/* padding: 40px 0 60px 0; */
	padding-top: 80px;    /* Abstand oben */
	padding-bottom: 80px; /* Abstand unten */
  }
  

  

  .row.why-cics__row {
	display: flex;
	flex-wrap: wrap;
	max-width: 1200px;
	margin: 100px auto;
	align-items: center; /* Bild und Text vertikal mittig */
	gap: 48px;
	padding: 0 24px;
  }
  
  .col {
	flex: 1 1 0;
	min-width: 320px;
  }
  
  .why-cics__left {
	max-width: 600px;
   
  }
  
  .why-cics__right {
	display: flex;
	justify-content: flex-end;
	align-items: center;
  }
  
  .why-cics__right img {
	width: 390px;
	max-width: 100%;
	border-radius: 12px;
	object-fit: cover;
	box-shadow: 0 6px 24px rgba(49,62,66,0.13);
	display: block;
  }
  
  .why-cics__left h1 {
	font-size: 1.7rem !important;
	font-weight: 900;
	margin-bottom: 24px;
	letter-spacing: -1px;
	line-height: 1.15;
	text-align: left;
	color: #110101;
	/* text-shadow: 0 1px 8px #fff, 0 1px 8px #fff; */
  }
  
  .why-cics__desc {
	font-size: 1.2rem !important;
	color: #000;
	margin-bottom: 32px;
	max-width: 95%;
  }
  
  .why-cics__list {
	list-style: none;
	padding: 0;
	margin: 0;
  }
  
  .why-cics__list li {
	border-bottom: 2px solid #e6e6e6;
  }
  
  .accordion-btn {
	width: 100%;
	background: none;
	border: none;
	outline: none;
	font: inherit;
	padding: 20px 0 18px 0;
	font-size: 0.90rem;
	font-weight: 700;
	color: #222;
	display: flex;
	justify-content: space-between;
	align-items: center;
	cursor: pointer;
	transition: background 0.2s;
  }
  
  .accordion-btn .plus {
	font-size: 1.4em;
	font-weight: 600;
	color: #313e42;
	margin-left: 16px;
	user-select: none;
	transition: transform 0.2s;
  }
  
  .accordion-btn.active .plus {
	transform: rotate(45deg); /* Dreht das Plus zu einem X */
  }
  
  .accordion-content {
	max-height: 0;
	overflow: hidden;
	transition: max-height 0.32s cubic-bezier(0.4,0,0.2,1);
	background: #f5f7fa;
	padding: 0 0;
  }
  
  .accordion-content p {
	margin: 0;
	padding: 10px 0 10px 0;
	color: #444;
	font-size: 0.85rem;
  }
  
  li.open .accordion-content {
	max-height: 100px; /* groß genug für den Text */
	padding: 0 0 0 0;
  }
  
  /* Responsive Design */
  @media (max-width: 900px) {
	.row.why-cics__row {
	  flex-direction: column;
	  align-items: stretch;
	  gap: 32px;
	}
	.why-cics__right {
	  justify-content: center;
	}
	.why-cics__right img {
	  width: 90vw;
	  max-width: 330px;
	}
  }
  
  @media (max-width: 600px) {
	.why-cics {
	  padding: 24px 0 32px 0;
	}
	.why-cics__left h1 {
	  font-size: 1.1rem;
	  margin-bottom: 14px;
	}
	.why-cics__desc {
	  font-size: 0.98rem;
	  margin-bottom: 18px;
	}
	.accordion-btn {
	  font-size: 1rem;
	  padding: 13px 0 12px 0;
	}
  }
</style>



<script>document.querySelectorAll('.accordion-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const li = btn.closest('li');
            const open = li.classList.contains('open');
            // Optional: Nur eine gleichzeitig öffnen
            document.querySelectorAll('.why-cics__list li').forEach(item => {
                item.classList.remove('open');
                item.querySelector('.accordion-btn').classList.remove('active');
            });
            if (!open) {
                li.classList.add('open');
                btn.classList.add('active');
            }
        });
    });</script>




  {{-- unsere firma end --}}


<!-- ---------------------serv2------------------------------- -->

<div class="container1">
    <div class="header">

        <div class="title">Welche Laptop &amp; Computerprobleme reparieren wir?</div>
    </div>
    <div class="services-grid">
        <!-- Service 1 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card1.png')}}" alt="Screen Replacement">
            <div class="service-title">Bauen Sie Ihren PC</div>
        </div>
        <!-- Service 2 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card2.jpeg')}}" alt="Laptop Fan Replacement">
            <div class="service-title">Laptop-Bildschirm austauschen</div>
        </div>
        <!-- Service 3 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card3.jpeg')}}" alt="Battery Replacement">
            <div class="service-title">Laptop-Lüfter und -Kühler austauschen</div>
        </div>
        <!-- Service 4 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card4.jpeg')}}" alt="Keyboard Repair">
            <div class="service-title">Laptop-Akku austauschen</div>
        </div>
        <!-- Service 5 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card5.jpeg')}}" alt="Cannot Power On">
            <div class="service-title">Laptop-Tastatur austauschen</div>
        </div>
        <!-- Service 6 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card10.jpeg')}}" alt="Hinge Repair">
            <div class="service-title">Einschalten nicht möglich</div>
        </div>
        <!-- Service 7 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card7.jpeg')}}" alt="Water Damage">
            <div class="service-title">Scharnierreparatur</div>
        </div>
        <!-- Service 8 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card8.jpeg')}}" alt="Connection Problem">
            <div class="service-title">Verbindungsproblem</div>
        </div>
        <!-- Service 9 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card9.jpeg')}}" alt="Screen Replacement">
            <div class="service-title">Computer Gaming Bauen</div>
        </div>
        <!-- Service 10 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card10.jpeg')}}" alt="Screen Replacement">
            <div class="service-title">Wasserschaden</div>
        </div>
        <!-- Service 11 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card11.jpeg')}}" alt="Screen Replacement">
            <div class="service-title">Austausch der Laptop-Festplatte</div>
        </div>
        <!-- Service 12 -->
        <div class="service-card">
            <img class="service-img" src="{{asset('images-/card12.jpeg')}}" alt="Screen Replacement">
            <div class="service-title">Laptop-Touchpad austauschen</div>
        </div>
    </div>
</div>

<style>
    /* ============================= services ====================== */


/* ============================= serv ====================== */



body {
	background: #fff;
	font-family: Arial, sans-serif;
	margin: 0;
	padding: 0;
}
.header {
	text-align: center;
	margin-top: 32px;
}

.title {
	font-size: 3.2rem;
	font-weight: bold;
	color: #222;
	margin-bottom: 53px;
	letter-spacing: 1px;
}
.subtitle {
	font-size: 1.3rem;
	color: #444;
	margin-bottom: 32px;
}
.services-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
	gap: 28px;
	max-width: 1100px;
	margin: 0 auto 40px auto;
	padding: 0 18px;
}
.service-card {
	background: #fff;
	border-radius: 10px;
	box-shadow: 0 2px 10px rgba(0,0,0,0.07);
	overflow: hidden;
	text-align: center;
	transition: box-shadow 0.18s;
}
.service-card:hover {
	box-shadow: 0 6px 18px rgba(0,0,0,0.13);
}
.service-img {
	width: 100%;
	height: 170px;
	object-fit: cover;
	display: block;
}
.service-title {
	font-size: 1.08rem;
	color: #333;
	font-weight: 500;
	margin: 18px 0 18px 0;
	letter-spacing: 0.5px;
}
@media (max-width: 700px) {
	.title { font-size: 1.2rem; }
	.services-grid { gap: 16px; }
	.service-img { height: 120px; }
}

</style>

<!-- ---------------------  end serv2------------------------------- -->
</div>