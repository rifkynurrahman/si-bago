<?php
/**
 * menu/simulasi.php
 * Konten halaman Simulasi Bangun Ruang 3D — content-only
 * Di-include oleh view_menu.php
 * Variabel $data tersedia dari view_menu.php, tapi tetap dijaga
 * agar aman jika file ini diakses/dites secara langsung.
 */

if (!isset($conn)) {
    include '../config/database.php';
}
if (!isset($data) || empty($data)) {
    $slug = 'simulasi';
    $data = $conn->query("SELECT * FROM menu WHERE slug='$slug'")->fetch_assoc();
    if (!$data) {
        $data = ['judul' => 'Simulasi Bangun Ruang 3D'];
    }
}
?>
<style>
.sim-header-text { text-align:justify; line-height:1.8; margin-bottom:25px; color:#444; }
.sim-app { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:10px; }
.sim-canvas-wrap {
    flex:3; min-width:280px;
    background:linear-gradient(135deg,#8B4513 0%,#D2691E 100%);
    border-radius:15px; padding:15px;
    box-shadow:0 8px 25px rgba(139,69,19,0.35);
}
.sim-control {
    flex:1; min-width:240px;
    background:linear-gradient(135deg,#8B4513 0%,#D2691E 100%);
    border-radius:15px; padding:18px;
    box-shadow:0 8px 25px rgba(139,69,19,0.35);
    color:#fff;
}
.canvas-box { width:100%; height:420px; border-radius:12px; overflow:hidden; background:#0a0a2a; cursor:grab; }
.canvas-box:active { cursor:grabbing; }
#sim_canvas3d { width:100%; height:100%; display:block; touch-action:none; }
.sim-drag-hint { text-align:center; font-size:0.75rem; color:rgba(255,255,255,0.6); margin-top:6px; }

/* View row wrap di mobile */
.sim-view-row { display:flex; flex-wrap:wrap; gap:5px; margin-top:8px; }
.sim-vbtn {
    flex:1; min-width:55px;
    background:rgba(255,255,255,0.12); color:#fff;
    border:1px solid rgba(255,255,255,0.15); border-radius:8px;
    padding:7px 4px; text-align:center; cursor:pointer;
    font-size:0.78rem; transition:background 0.2s; user-select:none;
}
.sim-vbtn:hover { background:rgba(255,215,0,0.3); }

.sim-info {
    background:rgba(0,0,0,0.25); border-radius:10px;
    padding:12px 15px; margin-top:12px;
    border:1px solid rgba(255,215,0,0.2);
}
.sim-info-title { color:#FFD700; font-weight:700; margin-bottom:10px; font-size:0.95rem; }
.sim-info-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(90px,1fr)); gap:8px; }
.sim-info-item { background:rgba(255,255,255,0.1); padding:8px 10px; border-radius:8px; }
.sim-info-label { font-size:0.72rem; color:#ffe0b2; margin-bottom:3px; }
.sim-info-val { font-size:0.95rem; font-weight:700; color:#FFD700; }

.sim-section { margin-bottom:18px; }
.sim-section h6 {
    font-size:0.9rem; color:#FFD700;
    border-bottom:1px solid rgba(255,215,0,0.4);
    padding-bottom:5px; margin-bottom:10px;
}
.sim-shapes { display:grid; grid-template-columns:repeat(3,1fr); gap:7px; }
.sim-shape {
    background:rgba(255,255,255,0.15); border:2px solid transparent;
    border-radius:10px; padding:7px 3px; text-align:center;
    cursor:pointer; color:#fff; font-size:0.68rem; transition:all 0.25s;
    word-break:break-word; line-height:1.3;
}
.sim-shape:hover { background:rgba(255,215,0,0.25); transform:translateY(-2px); }
.sim-shape.active { background:rgba(255,215,0,0.3); border-color:#FFD700; }
.sim-shape span { font-size:1.2rem; display:block; margin-bottom:3px; }

.sim-ctrl-group { margin-bottom:10px; }
.sim-ctrl-group label { display:block; font-size:0.82rem; color:#ddd; margin-bottom:4px; }
.sim-slider-row { display:flex; align-items:center; gap:8px; }
.sim-slider-row input[type=range] {
    flex:1; height:6px; border-radius:3px;
    background:rgba(255,255,255,0.2); outline:none; -webkit-appearance:none;
}
.sim-slider-row input[type=range]::-webkit-slider-thumb {
    -webkit-appearance:none; width:18px; height:18px;
    border-radius:50%; background:#FFD700; cursor:pointer;
}
.sim-val {
    min-width:38px; text-align:center; background:rgba(0,0,0,0.25);
    padding:3px 5px; border-radius:6px; font-size:0.78rem; color:#FFD700; font-weight:700;
}
.sim-colors { display:flex; gap:8px; flex-wrap:wrap; }
.sim-color { width:28px; height:28px; border-radius:50%; cursor:pointer; border:3px solid transparent; transition:transform 0.2s; }
.sim-color:hover { transform:scale(1.15); }
.sim-color.active { border-color:#FFD700; box-shadow:0 0 6px rgba(255,215,0,0.6); }
.sim-btns { display:flex; gap:8px; margin-top:12px; }
.sim-btns button {
    flex:1; padding:10px 5px; border:none; border-radius:9px;
    background:linear-gradient(to right,#5D2E0C,#A0522D);
    color:#FFD700; font-weight:700; cursor:pointer; font-size:0.85rem;
    transition:all 0.25s; border:1px solid rgba(255,215,0,0.4);
}
.sim-btns button:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.3); }

/* ── MOBILE OVERRIDES ── */
@media (max-width: 768px) {
    .sim-app { flex-direction:column; gap:14px; }
    .canvas-box { height:260px; }
    .sim-vbtn { font-size:0.7rem; padding:6px 2px; }
    .sim-info-grid { grid-template-columns:repeat(2,1fr); }
    .sim-shape { font-size:0.63rem; padding:6px 2px; }
    .sim-shape span { font-size:1.05rem; }
    /* Thumb lebih besar untuk jari */
    .sim-slider-row input[type=range]::-webkit-slider-thumb { width:22px; height:22px; }
    .sim-color { width:32px; height:32px; }
}
@media (max-width: 400px) {
    .canvas-box { height:220px; }
    .sim-info-grid { grid-template-columns:repeat(2,1fr); gap:6px; }
    .sim-info-item { padding:6px 7px; }
    .sim-info-val { font-size:0.85rem; }
}
</style>

<div class="container py-4 py-md-5">
    <h2 class="text-center mb-4 fw-bold" style="font-size:clamp(1.2rem,4vw,1.8rem);">
        <?php echo htmlspecialchars($data['judul']); ?>
    </h2>
    <div class="row">
        <div class="col-12 col-md-11 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-3 p-md-5">
                    <p class="sim-header-text">
                        Jelajahi bentuk-bentuk bangun ruang secara interaktif! Pilih bangun ruang, ubah ukurannya,
                        atur rotasi, dan lihat properti geometrisnya secara langsung. Kamu juga bisa
                        <strong>drag / sentuh canvas</strong> untuk memutar bangun ruang bebas.
                    </p>
                    <div class="sim-app">

                        <!-- Kiri: Canvas 3D -->
                        <div class="sim-canvas-wrap">
                            <div class="canvas-box">
                                <canvas id="sim_canvas3d"></canvas>
                            </div>
                            <div class="sim-drag-hint">🖱️ Drag / sentuh untuk memutar • Scroll/pinch untuk zoom</div>
                            <div class="sim-view-row">
                                <div class="sim-vbtn" data-view="perspective">Perspektif</div>
                                <div class="sim-vbtn" data-view="top">Atas</div>
                                <div class="sim-vbtn" data-view="front">Depan</div>
                                <div class="sim-vbtn" data-view="side">Samping</div>
                                <div class="sim-vbtn" data-view="wireframe">Wireframe</div>
                            </div>
                            <div class="sim-info">
                                <div class="sim-info-title">📊 Properti: <span id="sim_shapeName">KUBUS</span></div>
                                <div class="sim-info-grid">
                                    <div class="sim-info-item"><div class="sim-info-label">Volume</div><div class="sim-info-val"><span id="sim_vol">8.00</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Luas Permukaan</div><div class="sim-info-val"><span id="sim_lp">24.00</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Sisi/Muka</div><div class="sim-info-val"><span id="sim_faces">6</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Titik Sudut</div><div class="sim-info-val"><span id="sim_vert">8</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Rusuk</div><div class="sim-info-val"><span id="sim_edges">12</span></div></div>
                                </div>
                            </div>
                        </div>

                        <!-- Kanan: Panel Kontrol -->
                        <div class="sim-control">
                            <div class="sim-section">
                                <h6>Pilih Bangun Ruang</h6>
                                <div class="sim-shapes">
                                    <div class="sim-shape active" data-shape="cube"><span>⬛</span>Kubus</div>
                                    <div class="sim-shape" data-shape="balok"><span>📦</span>Balok</div>
                                    <div class="sim-shape" data-shape="sphere"><span>⚫</span>Bola</div>
                                    <div class="sim-shape" data-shape="cylinder"><span>🛢️</span>Tabung</div>
                                    <div class="sim-shape" data-shape="cone"><span>🔺</span>Kerucut</div>
                                    <div class="sim-shape" data-shape="prism_segitiga"><span>📐</span>Prisma △</div>
                                    <div class="sim-shape" data-shape="limas_segitiga"><span>🔷</span>Limas △</div>
                                    <div class="sim-shape" data-shape="prism_segiempat"><span>🧱</span>Prisma □</div>
                                </div>
                            </div>
                            <div class="sim-section">
                                <h6>Kontrol Dimensi</h6>
                                <div class="sim-ctrl-group">
                                    <label>Ukuran: <span id="sim_sizeVal">1.0</span></label>
                                    <div class="sim-slider-row"><input type="range" id="sim_size" min="0.5" max="3" step="0.1" value="1"><div class="sim-val" id="sim_sizeDisp">1.0</div></div>
                                </div>
                                <div class="sim-ctrl-group">
                                    <label>Rotasi X: <span id="sim_rxVal">0°</span></label>
                                    <div class="sim-slider-row"><input type="range" id="sim_rx" min="0" max="360" step="1" value="0"><div class="sim-val" id="sim_rxDisp">0°</div></div>
                                </div>
                                <div class="sim-ctrl-group">
                                    <label>Rotasi Y: <span id="sim_ryVal">0°</span></label>
                                    <div class="sim-slider-row"><input type="range" id="sim_ry" min="0" max="360" step="1" value="0"><div class="sim-val" id="sim_ryDisp">0°</div></div>
                                </div>
                                <div class="sim-ctrl-group">
                                    <label>Rotasi Z: <span id="sim_rzVal">0°</span></label>
                                    <div class="sim-slider-row"><input type="range" id="sim_rz" min="0" max="360" step="1" value="0"><div class="sim-val" id="sim_rzDisp">0°</div></div>
                                </div>
                            </div>
                            <div class="sim-section">
                                <h6>Warna</h6>
                                <div class="sim-colors">
                                    <div class="sim-color active" data-color="#4fc3f7" style="background:#4fc3f7"></div>
                                    <div class="sim-color" data-color="#ef5350" style="background:#ef5350"></div>
                                    <div class="sim-color" data-color="#66bb6a" style="background:#66bb6a"></div>
                                    <div class="sim-color" data-color="#ffca28" style="background:#ffca28"></div>
                                    <div class="sim-color" data-color="#ab47bc" style="background:#ab47bc"></div>
                                    <div class="sim-color" data-color="#ff7043" style="background:#ff7043"></div>
                                    <div class="sim-color" data-color="#ffffff" style="background:#ffffff"></div>
                                </div>
                            </div>
                            <div class="sim-btns">
                                <button id="sim_reset">🔄 Putar</button>
                                <button id="sim_random">🎲 Acak</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
(function() {
    let scene, camera, renderer, mesh;
    let color = '#4fc3f7', shapeType = 'cube', wireframe = false;
    let isDragging = false, prevX = 0, prevY = 0;
    let rotX = 0, rotY = 0, camDist = 8, orbitActive = false;

    const props = {
        cube:            { faces:6,  vert:8,  edges:12, vol:s=>s*s*s*8,                              lp:s=>6*(s*2)*(s*2) },
        balok:           { faces:6,  vert:8,  edges:12, vol:s=>s*2*s*s*3,                            lp:s=>2*(s*2*s+s*2*s*3+s*s*3) },
        sphere:          { faces:1,  vert:0,  edges:0,  vol:s=>(4/3)*Math.PI*s*s*s,                  lp:s=>4*Math.PI*s*s },
        cylinder:        { faces:3,  vert:0,  edges:2,  vol:s=>Math.PI*s*s*(s*2),                    lp:s=>2*Math.PI*s*(s+s*2) },
        cone:            { faces:2,  vert:1,  edges:1,  vol:s=>(1/3)*Math.PI*s*s*(s*2),              lp:s=>Math.PI*s*(s+Math.sqrt(s*s+(s*2)*(s*2))) },
        prism_segitiga:  { faces:5,  vert:6,  edges:9,  vol:s=>(Math.sqrt(3)/4)*s*s*(s*2),           lp:s=>2*(Math.sqrt(3)/4)*s*s+3*s*(s*2) },
        limas_segitiga:  { faces:4,  vert:4,  edges:6,  vol:s=>(1/3)*(Math.sqrt(3)/4)*s*s*(s*1.5),  lp:s=>(Math.sqrt(3)/4)*s*s+3*0.5*s*Math.sqrt((s/Math.sqrt(3))*(s/Math.sqrt(3))+(s*1.5)*(s*1.5)) },
        prism_segiempat: { faces:6,  vert:8,  edges:12, vol:s=>s*s*(s*2),                            lp:s=>2*s*s+4*s*(s*2) },
    };

    function buildLimasSegitigaGeo(s) {
        const h=s*1.5, r=s/Math.sqrt(3), y0=-h/2, y1=h/2;
        const A=new THREE.Vector3(0,y0,r*2), B=new THREE.Vector3(-s,y0,-r);
        const C=new THREE.Vector3(s,y0,-r),  T=new THREE.Vector3(0,y1,0);
        const positions=[], normals=[];
        function addFace(p1,p2,p3){
            const n=new THREE.Vector3().crossVectors(
                new THREE.Vector3().subVectors(p2,p1),
                new THREE.Vector3().subVectors(p3,p1)
            ).normalize();
            [p1,p2,p3].forEach(p=>{positions.push(p.x,p.y,p.z);normals.push(n.x,n.y,n.z);});
        }
        addFace(A,C,B); addFace(A,B,T); addFace(B,C,T); addFace(C,A,T);
        const geo=new THREE.BufferGeometry();
        geo.setAttribute('position',new THREE.Float32BufferAttribute(positions,3));
        geo.setAttribute('normal',  new THREE.Float32BufferAttribute(normals,3));
        return geo;
    }

    function init() {
        const canvas=document.getElementById('sim_canvas3d');
        const box=canvas.parentElement;
        scene=new THREE.Scene();
        scene.background=new THREE.Color('#0a0a2a');
        camera=new THREE.PerspectiveCamera(60,box.offsetWidth/box.offsetHeight,0.1,1000);
        updateCameraPos();
        renderer=new THREE.WebGLRenderer({canvas,antialias:true});
        renderer.setSize(box.offsetWidth,box.offsetHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));
        scene.add(new THREE.AmbientLight(0xffffff,0.7));
        const dl=new THREE.DirectionalLight(0xffffff,0.8); dl.position.set(5,10,7); scene.add(dl);
        const pl=new THREE.PointLight(0xD2691E,0.8,100);   pl.position.set(-5,-5,-5); scene.add(pl);
        buildShape('cube');
        bindEvents(canvas);
        loop();
    }

    function updateCameraPos() {
        camera.position.set(
            camDist*Math.sin(rotY)*Math.cos(rotX),
            camDist*Math.sin(rotX),
            camDist*Math.cos(rotY)*Math.cos(rotX)
        );
        camera.lookAt(0,0,0);
    }

    function buildShape(type) {
        if(mesh) scene.remove(mesh);
        shapeType=type;
        const s=parseFloat(document.getElementById('sim_size').value);
        let geo;
        switch(type){
            case 'cube':            geo=new THREE.BoxGeometry(s*2,s*2,s*2); break;
            case 'balok':           geo=new THREE.BoxGeometry(s*2,s,s*3); break;
            case 'sphere':          geo=new THREE.SphereGeometry(s,32,32); break;
            case 'cylinder':        geo=new THREE.CylinderGeometry(s,s,s*2,32); break;
            case 'cone':            geo=new THREE.ConeGeometry(s,s*2,32); break;
            case 'prism_segitiga':  geo=new THREE.CylinderGeometry(s,s,s*2,3); break;
            case 'limas_segitiga':  geo=buildLimasSegitigaGeo(s); break;
            case 'prism_segiempat': geo=new THREE.BoxGeometry(s,s*2,s); break;
            default:                geo=new THREE.BoxGeometry(s*2,s*2,s*2);
        }
        mesh=new THREE.Mesh(geo,new THREE.MeshPhongMaterial({
            color:new THREE.Color(color),wireframe,transparent:true,opacity:0.92,shininess:120
        }));
        mesh.rotation.x=parseFloat(document.getElementById('sim_rx').value)*Math.PI/180;
        mesh.rotation.y=parseFloat(document.getElementById('sim_ry').value)*Math.PI/180;
        mesh.rotation.z=parseFloat(document.getElementById('sim_rz').value)*Math.PI/180;
        scene.add(mesh);
        updateInfo(type,s);
    }

    function updateInfo(type,s) {
        const d=props[type]||props.cube;
        const labels={cube:'KUBUS',balok:'BALOK',sphere:'BOLA',cylinder:'TABUNG',cone:'KERUCUT',
            prism_segitiga:'PRISMA SEGITIGA',limas_segitiga:'LIMAS SEGITIGA',prism_segiempat:'PRISMA SEGIEMPAT'};
        document.getElementById('sim_shapeName').textContent=labels[type]||type.toUpperCase();
        document.getElementById('sim_vol').textContent  =d.vol(s).toFixed(2);
        document.getElementById('sim_lp').textContent   =d.lp(s).toFixed(2);
        document.getElementById('sim_faces').textContent=d.faces;
        document.getElementById('sim_vert').textContent =d.vert;
        document.getElementById('sim_edges').textContent=d.edges;
    }

    function getPos(e){ return e.touches?{x:e.touches[0].clientX,y:e.touches[0].clientY}:{x:e.clientX,y:e.clientY}; }
    function onPointerDown(e){ isDragging=true; orbitActive=true; const p=getPos(e); prevX=p.x; prevY=p.y; }
    function onPointerMove(e){
        if(!isDragging) return;
        const p=getPos(e), dx=p.x-prevX, dy=p.y-prevY;
        prevX=p.x; prevY=p.y;
        rotY+=dx*0.01; rotX+=dy*0.01;
        rotX=Math.max(-Math.PI/2+0.05,Math.min(Math.PI/2-0.05,rotX));
        updateCameraPos();
    }
    function onPointerUp(){ isDragging=false; }
    function onWheel(e){ camDist+=e.deltaY*0.01; camDist=Math.max(3,Math.min(20,camDist)); updateCameraPos(); e.preventDefault(); }

    function bindEvents(canvas) {
        canvas.addEventListener('mousedown',  onPointerDown);
        window.addEventListener('mousemove',  onPointerMove);
        window.addEventListener('mouseup',    onPointerUp);
        canvas.addEventListener('touchstart', onPointerDown,{passive:true});
        canvas.addEventListener('touchmove',  onPointerMove,{passive:true});
        canvas.addEventListener('touchend',   onPointerUp);
        canvas.addEventListener('wheel',      onWheel,{passive:false});

        // ── Pinch-to-zoom mobile ──
        let lastPinch=0;
        canvas.addEventListener('touchstart',e=>{
            if(e.touches.length===2) lastPinch=Math.hypot(e.touches[0].clientX-e.touches[1].clientX,e.touches[0].clientY-e.touches[1].clientY);
        },{passive:true});
        canvas.addEventListener('touchmove',e=>{
            if(e.touches.length===2){
                const d=Math.hypot(e.touches[0].clientX-e.touches[1].clientX,e.touches[0].clientY-e.touches[1].clientY);
                camDist-=(d-lastPinch)*0.05; camDist=Math.max(3,Math.min(20,camDist)); lastPinch=d; updateCameraPos();
            }
        },{passive:true});

        document.querySelectorAll('.sim-shape').forEach(el=>el.addEventListener('click',function(){
            document.querySelectorAll('.sim-shape').forEach(x=>x.classList.remove('active'));
            this.classList.add('active'); orbitActive=false; buildShape(this.dataset.shape);
        }));

        document.getElementById('sim_size').addEventListener('input',function(){
            const v=parseFloat(this.value).toFixed(1);
            document.getElementById('sim_sizeVal').textContent=v;
            document.getElementById('sim_sizeDisp').textContent=v;
            buildShape(shapeType);
        });

        ['rx','ry','rz'].forEach(ax=>document.getElementById('sim_'+ax).addEventListener('input',function(){
            document.getElementById('sim_'+ax+'Val').textContent=this.value+'°';
            document.getElementById('sim_'+ax+'Disp').textContent=this.value+'°';
            orbitActive=true;
            if(mesh){
                mesh.rotation.x=parseFloat(document.getElementById('sim_rx').value)*Math.PI/180;
                mesh.rotation.y=parseFloat(document.getElementById('sim_ry').value)*Math.PI/180;
                mesh.rotation.z=parseFloat(document.getElementById('sim_rz').value)*Math.PI/180;
            }
        }));

        document.querySelectorAll('.sim-color').forEach(el=>el.addEventListener('click',function(){
            document.querySelectorAll('.sim-color').forEach(x=>x.classList.remove('active'));
            this.classList.add('active'); color=this.dataset.color;
            if(mesh) mesh.material.color.set(color);
        }));

        document.getElementById('sim_reset').addEventListener('click',function(){
            ['rx','ry','rz'].forEach(ax=>{
                document.getElementById('sim_'+ax).value=0;
                document.getElementById('sim_'+ax+'Val').textContent='0°';
                document.getElementById('sim_'+ax+'Disp').textContent='0°';
            });
            rotX=0.4; rotY=0.6; updateCameraPos(); orbitActive=false;
            if(mesh){mesh.rotation.x=0;mesh.rotation.y=0;mesh.rotation.z=0;}
        });

        document.getElementById('sim_random').addEventListener('click',function(){
            const list=['cube','balok','sphere','cylinder','cone','prism_segitiga','limas_segitiga','prism_segiempat'];
            const r=list[Math.floor(Math.random()*list.length)];
            document.querySelectorAll('.sim-shape').forEach(x=>x.classList.remove('active'));
            document.querySelector('.sim-shape[data-shape="'+r+'"]').classList.add('active');
            buildShape(r);
            ['rx','ry','rz'].forEach(ax=>{
                const v=Math.floor(Math.random()*360);
                document.getElementById('sim_'+ax).value=v;
                document.getElementById('sim_'+ax+'Val').textContent=v+'°';
                document.getElementById('sim_'+ax+'Disp').textContent=v+'°';
            });
            orbitActive=true;
            if(mesh){
                mesh.rotation.x=parseFloat(document.getElementById('sim_rx').value)*Math.PI/180;
                mesh.rotation.y=parseFloat(document.getElementById('sim_ry').value)*Math.PI/180;
                mesh.rotation.z=parseFloat(document.getElementById('sim_rz').value)*Math.PI/180;
            }
        });

        document.querySelectorAll('.sim-vbtn').forEach(btn=>btn.addEventListener('click',function(){
            const v=this.dataset.view;
            if(v==='wireframe'){
                wireframe=!wireframe;
                if(mesh){mesh.material.wireframe=wireframe; this.textContent=wireframe?'Solid':'Wireframe';}
            } else {
                document.querySelectorAll('.sim-vbtn').forEach(b=>{if(b.dataset.view!=='wireframe')b.style.background='';});
                this.style.background='rgba(255,215,0,0.3)'; orbitActive=true;
                const views={perspective:{rx:0.4,ry:0.6,d:8},top:{rx:1.55,ry:0,d:8},front:{rx:0,ry:0,d:8},side:{rx:0,ry:1.57,d:8}};
                const vv=views[v]||views.perspective;
                rotX=vv.rx; rotY=vv.ry; camDist=vv.d; updateCameraPos();
            }
        }));

        window.addEventListener('resize',function(){
            const c=document.getElementById('sim_canvas3d');
            camera.aspect=c.offsetWidth/c.offsetHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(c.offsetWidth,c.offsetHeight);
        });
    }

    rotX=0.4; rotY=0.6;

    function loop(){
        requestAnimationFrame(loop);
        if(!orbitActive&&mesh){
            const rx=parseFloat(document.getElementById('sim_rx').value);
            const ry=parseFloat(document.getElementById('sim_ry').value);
            const rz=parseFloat(document.getElementById('sim_rz').value);
            if(rx===0&&ry===0&&rz===0){rotY+=0.005; updateCameraPos();}
        }
        renderer.render(scene,camera);
    }

    document.readyState==='loading'?document.addEventListener('DOMContentLoaded',init):init();
})();
</script>