@extends('layouts.frontend')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
<style>
    :root {
      --v2-bg: #06061e;
      --v2-card: rgba(255, 255, 255, 0.02);
      --v2-glass: rgba(13, 11, 40, 0.7);
      --v2-border: rgba(255, 255, 255, 0.08);
      --v2-primary: #f05223;
      --v2-primary-glow: rgba(240, 82, 35, 0.35);
      --v2-secondary: #3b82f6;
      --v2-text-main: #f0eeff;
      --v2-text-muted: #94a3b8;
    }

    .portfolio-page-wrapper {
      background: var(--v2-bg);
      background-image: 
        radial-gradient(circle at 20% 0%, rgba(240, 82, 35, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 80% 100%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
      color: var(--v2-text-main);
      min-height: 100vh;
      padding-top: 140px;
    }

    /* HERO */
    .portfolio-hero {
      padding: 80px 0;
      text-align: center;
      position: relative;
    }
    .hero-badge-v4 {
      display: inline-flex; align-items: center; gap: 10px;
      font-size: .8rem; font-weight: 800; letter-spacing: 2px;
      text-transform: uppercase; color: var(--v2-primary);
      background: rgba(240, 82, 35, 0.1);
      border: 1px solid rgba(240, 82, 35, 0.2);
      border-radius: 100px; padding: 8px 24px;
      margin-bottom: 30px;
      backdrop-filter: blur(10px);
    }
    .hero-title-v4 {
      font-size: clamp(3rem, 8vw, 5rem);
      font-weight: 900; line-height: 1;
      letter-spacing: -2px; margin-bottom: 30px;
      background: linear-gradient(to bottom, #fff 50%, rgba(255,255,255,0.5));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .hero-sub-v4 {
      color: var(--v2-text-muted); font-size: 1.25rem;
      max-width: 700px; margin: 0 auto 40px; line-height: 1.6;
    }

    /* GLASS FILTER BAR */
    .filter-sticky-wrapper {
      position: sticky; top: 100px; z-index: 1000;
      padding: 25px 0;
    }
    .filter-glass-container {
      background: rgba(13, 11, 40, 0.6);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 100px;
      padding: 10px;
      max-width: 100%;
      width: fit-content;
      margin: 0 auto;
      display: flex;
      align-items: center;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .filter-inner {
      display: flex;
      overflow-x: auto;
      gap: 8px;
      padding: 0 10px;
      scrollbar-width: none;
      scroll-behavior: smooth;
    }
    .filter-inner::-webkit-scrollbar { display: none; }

    .filter-btn {
      font-size: .9rem; font-weight: 700;
      padding: 12px 28px; border-radius: 100px;
      border: 1px solid transparent;
      background: transparent;
      color: var(--v2-text-muted); cursor: pointer;
      transition: all .4s cubic-bezier(0.16, 1, 0.3, 1);
      white-space: nowrap;
    }
    .filter-btn:hover {
      color: #fff;
      background: rgba(255, 255, 255, 0.05);
    }
    .filter-btn.active {
      background: var(--v2-primary);
      color: #fff;
      box-shadow: 0 10px 20px var(--v2-primary-glow);
    }
    .btn-scroll {
      background: transparent;
      border: none;
      color: var(--v2-text-muted);
      font-size: 1.2rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0 15px;
      transition: color 0.3s;
      z-index: 10;
    }
    .btn-scroll:hover { color: #fff; }
    .btn-scroll:disabled { opacity: 0.3; cursor: not-allowed; }

    @media (max-width: 768px) {
      .filter-glass-container { width: 100%; border-radius: 30px; }
      .btn-scroll { padding: 0 10px; }
    }

    /* GRID */
    .portfolio-grid { padding: 40px 0 120px; }
    
    /* PREMIUM CARD */
    .p-card {
      background: rgba(255, 255, 255, 0.02);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 32px; overflow: hidden;
      transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      display: flex; flex-direction: column; height: 100%;
    }
    .p-card:hover {
      transform: translateY(-15px);
      border-color: var(--v2-primary);
      box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 30px rgba(240, 82, 35, 0.1);
    }

    .p-card__thumb {
      position: relative; aspect-ratio: 16/10;
      overflow: hidden; background: #000;
    }
    .p-card__thumb img {
      width:100%; height:100%; object-fit:cover;
      opacity: 0.85; transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .p-card:hover .p-card__thumb img { transform: scale(1.1); opacity: 1; }

    .p-card__overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(6,6,30,0.9) 0%, transparent 70%);
      display: flex; align-items: flex-end; padding: 30px;
      opacity: 0; transition: all 0.4s ease;
    }
    .p-card:hover .p-card__overlay { opacity: 1; }

    .p-card__body {
      padding: 30px;
      display: flex; flex-direction: column; flex: 1;
    }
    .p-card__cats {
      display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
    }
    .p-cat {
      font-size: .7rem; font-weight: 800; letter-spacing: 1px;
      text-transform: uppercase; border-radius: 8px; padding: 6px 14px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1); color: var(--v2-text-muted);
    }
    .p-card:hover .p-cat { border-color: rgba(240, 82, 35, 0.3); color: #fff; }

    .p-card__title {
      font-size: 1.5rem; font-weight: 800;
      color: #fff; line-height: 1.2;
      margin-bottom: 15px; text-decoration: none;
      transition: color 0.3s ease;
    }
    .p-card:hover .p-card__title { color: var(--v2-primary); }
    
    .p-card__tags {
      display: flex; flex-wrap: wrap; gap: 8px;
      margin-top: auto;
    }
    .p-tag {
      font-size: .8rem; color: var(--v2-text-muted);
      font-weight: 600;
    }
    .p-tag::before { content: '/'; color: var(--v2-primary); margin-right: 4px; }

    .p-card__visit-btn {
      padding: 12px 25px; border-radius: 15px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      color: #fff; font-size: .9rem; font-weight: 700;
      text-decoration: none; display: flex; align-items: center; gap: 10px;
      transition: all 0.3s ease;
    }
    .p-card:hover .p-card__visit-btn {
      background: var(--v2-primary);
      border-color: transparent;
      box-shadow: 0 10px 20px var(--v2-primary-glow);
    }

    /* EMPTY STATE */
    .empty-state {
      grid-column: 1 / -1;
      text-align: center; padding: 120px 0;
      background: rgba(255, 255, 255, 0.02); border-radius: 32px; border: 1px dashed rgba(255, 255, 255, 0.1);
    }
    .empty-state i { font-size: 4rem; color: var(--v2-primary); margin-bottom: 20px; display: block; }

    /* PAGINATION */
    .pagination-wrap {
      display: flex; justify-content: center; align-items: center;
      gap: 12px; padding-bottom: 100px;
    }
    .pg-btn {
      width: 48px; height: 48px; border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: rgba(255,255,255,0.03);
      color: var(--v2-text-muted); font-size: 1rem; font-weight: 800;
      cursor: pointer; transition: all .3s;
      display: flex; align-items: center; justify-content: center;
    }
    .pg-btn:hover { border-color: var(--v2-primary); color: #fff; background: rgba(240,82,35,0.1); }
    .pg-btn.active {
      background: var(--v2-primary);
      border-color: transparent; color: #fff;
      box-shadow: 0 10px 20px var(--v2-primary-glow);
    }
    .pg-btn:disabled { opacity:.2; pointer-events:none; }

    /* ANIM */
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
    .fade-in {
      opacity: 0; transform: translateY(20px);
      animation: fadeUp .45s ease forwards;
    }
</style>
@endpush

<div class="portfolio-page-wrapper">
    <div class="container" style="max-width:1260px;">

        <!-- HERO -->
        <div class="portfolio-hero">
          <div class="h-glow h-glow-1"></div>
          <div class="h-glow h-glow-2"></div>
          <div class="h-glow h-glow-3"></div>

          <div class="hero-badge-v4" data-aos="fade-down">
            <i class="bi bi-grid-3x3-gap-fill"></i> Our Portfolio
          </div>
          <h1 class="hero-title-v4" data-aos="fade-up">
            Work Experience in<br>
            <span class="text-primary">Various Fields</span> &amp; <span class="text-white-50">Skills</span>
          </h1>
          <p class="hero-sub-v4" data-aos="fade-up" data-aos-delay="100">
            Transforming your vision into digital reality — from eCommerce to Healthcare, Agency to LMS and beyond.
          </p>
        </div>

        <!-- FILTERS -->
        <div class="filter-sticky-wrapper" data-aos="fade-up">
          <div class="filter-glass-container position-relative">
            <button class="btn-scroll filter-scroll-left" id="scrollLeft"><i class="fas fa-chevron-left"></i></button>
            <div class="filter-inner" id="filterBar">
              <button class="filter-btn active" data-filter="all">All Projects</button>
              @foreach($categories as $category)
                  <button class="filter-btn" data-filter="{{ $category->slug }}">{{ $category->name }}</button>
              @endforeach
            </div>
            <button class="btn-scroll filter-scroll-right" id="scrollRight"><i class="fas fa-chevron-right"></i></button>
          </div>
        </div>

        <!-- GRID -->
        <div class="portfolio-grid">
          <div class="row g-4" id="portfolioGrid">
              <!-- Projects will be rendered here by JS -->
          </div>
          <div class="empty-state" id="emptyState">
            <i class="bi bi-folder-x"></i>
            <p>No projects found for this category.</p>
          </div>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrap" id="paginationWrap"></div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBar = document.getElementById('filterBar');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');

        const updateScrollButtons = () => {
            if (filterBar.scrollLeft > 0) {
                scrollLeftBtn.style.opacity = '1';
                scrollLeftBtn.disabled = false;
            } else {
                scrollLeftBtn.style.opacity = '0.3';
                scrollLeftBtn.disabled = true;
            }

            if (filterBar.scrollWidth - filterBar.clientWidth - filterBar.scrollLeft > 1) {
                scrollRightBtn.style.opacity = '1';
                scrollRightBtn.disabled = false;
            } else {
                scrollRightBtn.style.opacity = '0.3';
                scrollRightBtn.disabled = true;
            }
        };

        if(filterBar && scrollLeftBtn && scrollRightBtn) {
            scrollLeftBtn.addEventListener('click', () => {
                filterBar.scrollBy({ left: -250, behavior: 'smooth' });
            });

            scrollRightBtn.addEventListener('click', () => {
                filterBar.scrollBy({ left: 250, behavior: 'smooth' });
            });

            filterBar.addEventListener('scroll', updateScrollButtons);
            window.addEventListener('resize', updateScrollButtons);
            setTimeout(updateScrollButtons, 100);
        }
    });

    const blueCats = new Set(['wix','wordpress','lms','membership','blogs','newspaper','shopify']);
    
    // Inject projects from PHP to JS (pre-processed in controller)
    const projects = @json($projectsForJs);

    const PER_PAGE = 12;
    let activeFilter = 'all', currentPage = 1;
    const grid = document.getElementById('portfolioGrid');
    const emptyState = document.getElementById('emptyState');
    const pgWrap = document.getElementById('paginationWrap');

    function filtered() {
      if (activeFilter === 'all') return projects;
      return projects.filter(p => p.cats.some(c => c.slug === activeFilter));
    }

    function render() {
      const data = filtered();
      const total = Math.ceil(data.length/PER_PAGE);
      if (currentPage>total) currentPage=1;
      const slice = data.slice((currentPage-1)*PER_PAGE, currentPage*PER_PAGE);

      grid.innerHTML='';
      if (!slice.length) { emptyState.style.display='block'; pgWrap.innerHTML=''; return; }
      emptyState.style.display='none';

      slice.forEach((p,i) => {
        const col = document.createElement('div');
        col.className='col-12 col-sm-6 col-lg-4 col-item';
        
        const categoriesHtml = p.cats.map(c => 
            `<span class="p-cat ${blueCats.has(c.slug)?'bc':'oc'}">${c.name}</span>`
        ).join('');

        col.innerHTML=`
          <div class="p-card fade-in" style="animation-delay:${i*0.055}s">
            <div class="p-card__thumb">
              <img src="${p.img}" alt="${p.title}" loading="lazy"/>
              <div class="p-card__overlay">
                <a href="${p.url}" target="_blank" rel="noopener" class="p-card__visit-btn">
                  View Project <i class="bi bi-arrow-up-right"></i>
                </a>
              </div>
            </div>
            <div class="p-card__body">
              <div class="p-card__cats">
                ${categoriesHtml}
              </div>
              <a href="${p.url}" target="_blank" rel="noopener" class="p-card__title">${p.title}</a>
              <div class="p-card__tags">
                ${p.tags.filter(t => t.trim() !== '').map(t=>`<span class="p-tag">${t}</span>`).join('')}
              </div>
            </div>
          </div>`;
        grid.appendChild(col);
      });

      pgWrap.innerHTML='';
      if (total<=1) return;
      pgWrap.appendChild(mkBtn('<i class="fas fa-chevron-left"></i>', currentPage===1, ()=>{currentPage--;render();up();}));
      for (let i=1;i<=total;i++) {
        const b=mkBtn(i,false,()=>{currentPage=i;render();up();});
        if(i===currentPage) b.classList.add('active');
        pgWrap.appendChild(b);
      }
      pgWrap.appendChild(mkBtn('<i class="fas fa-chevron-right"></i>', currentPage===total, ()=>{currentPage++;render();up();}));
    }

    function mkBtn(html,disabled,fn){
      const b=document.createElement('button');
      b.className='pg-btn'; b.innerHTML=html; b.disabled=disabled;
      b.addEventListener('click',fn); return b;
    }
    function up(){ window.scrollTo({top:grid.offsetTop-150,behavior:'smooth'}); }

    document.getElementById('filterBar').addEventListener('click',e=>{
      const b=e.target.closest('.filter-btn'); if(!b) return;
      document.querySelectorAll('.filter-btn').forEach(x=>x.classList.remove('active'));
      b.classList.add('active'); activeFilter=b.dataset.filter; currentPage=1; render();
    });

    render();
</script>
@endpush
@endsection
