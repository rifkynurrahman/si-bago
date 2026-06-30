<?php
/**
 * menu/simulasi.php
 * Konten halaman Simulasi Bangun Datar 2D — Murni HTML5 Canvas 2D
 * Di-include oleh view_menu.php
 */

if (!isset($conn)) {
    include '../config/database.php';
}
if (!isset($data) || empty($data)) {
    $slug = 'simulasi';
    $data = $conn->query("SELECT * FROM menu WHERE slug='$slug'")->fetch_assoc();
    if (!$data) {
        $data = ['judul' => 'Simulasi Bangun Datar 2D'];
    }
}
?>
<style>
.sim-header-text { text-align:justify; line-height:1.8; margin-bottom:25px; color:#4a5a6a; }
.sim-app { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:10px; }
.sim-canvas-wrap {
    flex:3; min-width:280px;
    background: #F4F6F9;
    border-radius:15px; padding:15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
}
.sim-control {
    flex:1; min-width:240px;
    background: linear-gradient(135deg, #7AA0CD 0%, #A2C2E8 100%);
    border-radius:15px; padding:18px;
    box-shadow: 0 8px 25px rgba(122, 160, 205, 0.3);
    color:#fff;
}
.canvas-box { width:100%; height:420px; border-radius:12px; overflow:hidden; background:#ffffff; border: 1px solid #e2e8f0; position: relative; }
#sim_canvas2d { width:100%; height:100%; display:block; }
.sim-drag-hint { text-align:center; font-size:0.75rem; color:#7a8a9a; margin-top:6px; }

/* View row wrap di mobile */
.sim-view-row { display:flex; flex-wrap:wrap; gap:5px; margin-top:8px; }
.sim-vbtn {
    flex:1; min-width:55px;
    background:rgba(255,255,255,0.7); color:#2C3E50;
    border:1px solid #cbd5e1; border-radius:8px;
    padding:7px 4px; text-align:center; cursor:pointer;
    font-size:0.78rem; transition:all 0.2s; user-select:none;
    font-weight: 600;
}
.sim-vbtn:hover, .sim-vbtn.active { background:#7AA0CD; color:#fff; border-color:#7AA0CD; }

.sim-info {
    background: #ffffff; border-radius:10px;
    padding:12px 15px; margin-top:12px;
    border:1px solid #e2e8f0;
}
.sim-info-title { color:#2C3E50; font-weight:700; margin-bottom:10px; font-size:0.95rem; }
.sim-info-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); gap:8px; }
.sim-info-item { background:#F4F6F9; padding:8px 10px; border-radius:8px; border: 1px solid #e2e8f0; }
.sim-info-label { font-size:0.72rem; color:#64748b; margin-bottom:3px; font-weight: 600; }
.sim-info-val { font-size:0.95rem; font-weight:700; color:#2C3E50; }

.sim-section { margin-bottom:18px; }
.sim-section h6 {
    font-size:0.9rem; color:#fff; font-weight: 700;
    border-bottom:2px solid rgba(255,255,255,0.3);
    padding-bottom:5px; margin-bottom:10px;
}
.sim-shapes { display:grid; grid-template-columns:repeat(2,1fr); gap:7px; }
.sim-shape {
    background:rgba(255,255,255,0.2); border:2px solid transparent;
    border-radius:10px; padding:8px 4px; text-align:center;
    cursor:pointer; color:#fff; font-size:0.72rem; transition:all 0.25s;
    word-break:break-word; line-height:1.3; font-weight: 500;
}
.sim-shape:hover { background:rgba(255,255,255,0.35); transform:translateY(-2px); }
.sim-shape.active { background:#fff; border-color:#fff; color: #2C3E50; font-weight: 700; }
.sim-shape span { font-size:1.1rem; display:block; margin-bottom:2px; }

.sim-ctrl-group { margin-bottom:10px; }
.sim-ctrl-group label { display:block; font-size:0.82rem; color:#fff; margin-bottom:4px; font-weight: 500; }
.sim-slider-row { display:flex; align-items:center; gap:8px; }
.sim-slider-row input[type=range] {
    flex:1; height:6px; border-radius:3px;
    background:rgba(255,255,255,0.3); outline:none; -webkit-appearance:none;
}
.sim-slider-row input[type=range]::-webkit-slider-thumb {
    -webkit-appearance:none; width:18px; height:18px;
    border-radius:50%; background:#ffffff; cursor:pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
.sim-val {
    min-width:38px; text-align:center; background:rgba(0,0,0,0.15);
    padding:3px 5px; border-radius:6px; font-size:0.78rem; color:#fff; font-weight:700;
}
.sim-colors { display:flex; gap:8px; flex-wrap:wrap; }
.sim-color { width:28px; height:28px; border-radius:50%; cursor:pointer; border:3px solid transparent; transition:transform 0.2s; }
.sim-color:hover { transform:scale(1.15); }
.sim-color.active { border-color:#ffffff; box-shadow:0 0 8px rgba(255,255,255,0.8); }
.sim-btns { display:flex; gap:8px; margin-top:12px; }
.sim-btns button {
    flex:1; padding:10px 5px; border:none; border-radius:9px;
    background:#ffffff;
    color:#2C3E50; font-weight:700; cursor:pointer; font-size:0.85rem;
    transition:all 0.25s; border:1px solid rgba(255,255,255,0.5);
}
.sim-btns button:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,0.15); background: #f8fafc; }

/* ── MOBILE OVERRIDES ── */
@media (max-width: 768px) {
    .sim-app { flex-direction:column; gap:14px; }
    .canvas-box { height:260px; }
    .sim-vbtn { font-size:0.7rem; padding:6px 2px; }
    .sim-info-grid { grid-template-columns:repeat(2,1fr); }
    .sim-shape { font-size:0.68rem; padding:6px 2px; }
    .sim-slider-row input[type=range]::-webkit-slider-thumb { width:22px; height:22px; }
    .sim-color { width:32px; height:32px; }
}
</style>

<div class="container py-4 py-md-5">
    <h2 class="text-center mb-4 fw-bold" style="font-size:clamp(1.2rem,4vw,1.8rem); color:#2C3E50;">
        <?php echo htmlspecialchars($data['judul']); ?>
    </h2>
    <div class="row">
        <div class="col-12 col-md-11 mx-auto">
            <div class="card shadow-sm border-0" style="border-radius:15px;">
                <div class="card-body p-3 p-md-5">
                    <p class="sim-header-text">
                        Jelajahi bentuk-bentuk <strong>Bangun Datar (2D)</strong> secara interaktif! Pilih bentuk geometri di bawah ini, ubah variabel dimensinya, dan amati perubahan kalkulasi nilai Luas serta Kelilingnya secara langsung (real-time).
                    </p>
                    <div class="sim-app">

                        <div class="sim-canvas-wrap">
                            <div class="canvas-box">
                                <canvas id="sim_canvas2d"></canvas>
                            </div>
                            <div class="sim-drag-hint">📏 Visualisasi 2D dengan rendering garis tepi presisi tinggi</div>
                            <div class="sim-view-row">
                                <div class="sim-vbtn active" id="btn_solid">Mode Solid</div>
                                <div class="sim-vbtn" id="btn_wireframe">Mode Garis</div>
                            </div>
                            <div class="sim-info">
                                <div class="sim-info-title">📊 Properti Geometri: <span id="sim_shapeName">PERSEGI</span></div>
                                <div class="sim-info-grid">
                                    <div class="sim-info-item"><div class="sim-info-label">Luas (L)</div><div class="sim-info-val"><span id="sim_vol">4.00</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Keliling (K)</div><div class="sim-info-val"><span id="sim_lp">8.00</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Jumlah Sisi</div><div class="sim-info-val"><span id="sim_faces">4</span></div></div>
                                    <div class="sim-info-item"><div class="sim-info-label">Titik Sudut</div><div class="sim-info-val"><span id="sim_vert">4</span></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="sim-control">
                            <div class="sim-section">
                                <h6>Pilih Bangun Datar</h6>
                                <div class="sim-shapes">
                                    <div class="sim-shape active" data-shape="persegi"><span>⬜</span>Persegi</div>
                                    <div class="sim-shape" data-shape="persegipanjang"><span>▭</span>Persegi Panjang</div>
                                    <div class="sim-shape" data-shape="lingkaran"><span>⚪</span>Lingkaran</div>
                                    <div class="sim-shape" data-shape="segitiga"><span>▲</span>Segitiga Sisi</div>
                                    <div class="sim-shape" data-shape="jajargenjang"><span>▰</span>Jajar Genjang</div>
                                    <div class="sim-shape" data-shape="layanglayang"><span>🪁</span>Layang-Layang</div>
                                    <div class="sim-shape" data-shape="belahketupat"><span>🔶</span>Belah Ketupat</div>
                                    <div class="sim-shape" data-shape="trapesium"><span>⏃</span>Trapesium</div>
                                </div>
                            </div>
                            <div class="sim-section">
                                <h6>Kontrol Dimensi</h6>
                                <div class="sim-ctrl-group" id="group_p">
                                    <label id="label_p">Panjang Sisi (s): <span id="sim_sizeVal">2.0</span></label>
                                    <div class="sim-slider-row"><input type="range" id="sim_size" min="1" max="5" step="0.1" value="2"><div class="sim-val" id="sim_sizeDisp">2.0</div></div>
                                </div>
                                <div class="sim-ctrl-group" id="group_l" style="display:none;">
                                    <label id="label_l">Lebar (l): <span id="sim_lVal">1.5</span></label>
                                    <div class="sim-slider-row"><input type="range" id="sim_l" min="1" max="5" step="0.1" value="1.5"><div class="sim-val" id="sim_lDisp">1.5</div></div>
                                </div>
                            </div>
                            <div class="sim-section">
                                <h6>Warna Objek</h6>
                                <div class="sim-colors">
                                    <div class="sim-color active" data-color="#7AA0CD" style="background:#7AA0CD"></div>
                                    <div class="sim-color" data-color="#ef5350" style="background:#ef5350"></div>
                                    <div class="sim-color" data-color="#66bb6a" style="background:#66bb6a"></div>
                                    <div class="sim-color" data-color="#ffca28" style="background:#ffca28"></div>
                                    <div class="sim-color" data-color="#ab47bc" style="background:#ab47bc"></div>
                                    <div class="sim-color" data-color="#ff7043" style="background:#ff7043"></div>
                                </div>
                            </div>
                            <div class="sim-btns">
                                <button id="sim_reset">🔄 Reset</button>
                                <button id="sim_random">🎲 Acak</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const canvas = document.getElementById('sim_canvas2d');
    const ctx = canvas.getContext('2d');
    
    let color = '#7AA0CD';
    let shapeType = 'persegi';
    let displayMode = 'solid'; // solid atau wireframe

    const props = {
        persegi:        { nama: 'PERSEGI', sisi: 4, sudut: 4 },
        persegipanjang: { nama: 'PERSEGI PANJANG', sisi: 4, sudut: 4 },
        lingkaran:      { nama: 'LINGKARAN', sisi: 1, sudut: 0 },
        segitiga:       { nama: 'SEGITIGA SAMA SISI', sisi: 3, sudut: 3 },
        jajargenjang:   { nama: 'JAJAR GENJANG', sisi: 4, sudut: 4 },
        layanglayang:   { nama: 'LAYANG-LAYANG', sisi: 4, sudut: 4 },
        belahketupat:   { nama: 'BELAH KETUPAT', sisi: 4, sudut: 4 },
        trapesium:      { nama: 'TRAPESIUM SAMA KAKI', sisi: 4, sudut: 4 }
    };

    function resizeCanvas() {
        const box = canvas.parentElement;
        canvas.width = box.clientWidth;
        canvas.height = box.clientHeight;
        draw();
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        const p = parseFloat(document.getElementById('sim_size').value);
        const l = parseFloat(document.getElementById('sim_l').value);
        
        // Faktor skala pixel agar pas di tengah canvas
        const scale = 50; 
        const cx = canvas.width / 2;
        const cy = canvas.height / 2;

        let luas = 0, keliling = 0;

        ctx.beginPath();
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#2C3E50';
        ctx.fillStyle = color;

        switch(shapeType) {
            case 'persegi':
                let sPx = p * scale;
                ctx.rect(cx - sPx/2, cy - sPx/2, sPx, sPx);
                luas = p * p;
                keliling = 4 * p;
                break;
                
            case 'persegipanjang':
                let wPx = p * scale;
                let hPx = l * scale;
                ctx.rect(cx - wPx/2, cy - hPx/2, wPx, hPx);
                luas = p * l;
                keliling = 2 * (p + l);
                break;
                
            case 'lingkaran':
                let rPx = (p / 2) * scale;
                ctx.arc(cx, cy, rPx, 0, Math.PI * 2);
                luas = Math.PI * (p/2) * (p/2);
                keliling = 2 * Math.PI * (p/2);
                break;
                
            case 'segitiga':
                let sidePx = p * scale;
                let hTriPx = (Math.sqrt(3)/2) * sidePx;
                ctx.moveTo(cx, cy - (2/3)*hTriPx);
                ctx.lineTo(cx + sidePx/2, cy + (1/3)*hTriPx);
                ctx.lineTo(cx - sidePx/2, cy + (1/3)*hTriPx);
                ctx.closePath();
                luas = 0.5 * p * ((Math.sqrt(3)/2) * p);
                keliling = 3 * p;
                break;
                
            case 'jajargenjang':
                let jW = p * scale;
                let jH = l * scale;
                let jShift = jH * 0.4;
                ctx.moveTo(cx - jW/2 - jShift, cy + jH/2);
                ctx.lineTo(cx + jW/2 - jShift, cy + jH/2);
                ctx.lineTo(cx + jW/2 + jShift, cy - jH/2);
                ctx.lineTo(cx - jW/2 + jShift, cy - jH/2);
                ctx.closePath();
                luas = p * l;
                let miringJajar = Math.sqrt((l * 0.4)*(l * 0.4) + l*l);
                keliling = 2 * (p + miringJajar);
                break;
                
            case 'layanglayang':
                let d1 = p * scale;
                let d2 = l * scale;
                ctx.moveTo(cx, cy - d2/2); // Atas
                ctx.lineTo(cx + d1/3, cy); // Kanan
                ctx.lineTo(cx, cy + d2/2); // Bawah
                ctx.lineTo(cx - d1/3, cy); // Kiri
                ctx.closePath();
                luas = 0.5 * p * l;
                let s1 = Math.sqrt((p/3)*(p/3) + (l/2)*(l/2));
                let s2 = Math.sqrt((p/3)*(p/3) + (l/2)*(l/2));
                keliling = 2 * (s1 + s2);
                break;
                
            case 'belahketupat':
                let bd1 = p * scale;
                let bd2 = l * scale;
                ctx.moveTo(cx, cy - bd2/2);
                ctx.lineTo(cx + bd1/2, cy);
                ctx.lineTo(cx, cy + bd2/2);
                ctx.lineTo(cx - bd1/2, cy);
                ctx.closePath();
                luas = 0.5 * p * l;
                let s_belah = Math.sqrt((p/2)*(p/2) + (l/2)*(l/2));
                keliling = 4 * s_belah;
                break;
                
            case 'trapesium':
                let tW1 = p * scale; // Alas bawah
                let tW2 = p * 0.6 * scale; // Alas atas
                let tH = l * scale;
                ctx.moveTo(cx - tW1/2, cy + tH/2);
                ctx.lineTo(cx + tW1/2, cy + tH/2);
                ctx.lineTo(cx + tW2/2, cy - tH/2);
                ctx.lineTo(cx - tW2/2, cy - tH/2);
                ctx.closePath();
                luas = 0.5 * (p + (p * 0.6)) * l;
                let dx = (p - (p * 0.6)) / 2;
                let miringTrap = Math.sqrt(dx*dx + l*l);
                keliling = p + (p * 0.6) + (2 * miringTrap);
                break;
        }

        if (displayMode === 'solid') {
            ctx.fill();
        }
        ctx.stroke();

        // Update teks info properti matematika
        const d = props[shapeType];
        document.getElementById('sim_shapeName').textContent = d.nama;
        document.getElementById('sim_vol').textContent = luas.toFixed(2);
        document.getElementById('sim_lp').textContent = keliling.toFixed(2);
        document.getElementById('sim_faces').textContent = d.sisi;
        document.getElementById('sim_vert').textContent = d.sudut;
    }

    function bindEvents() {
        document.querySelectorAll('.sim-shape').forEach(el => el.addEventListener('click', function() {
            document.querySelectorAll('.sim-shape').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            
            shapeType = this.dataset.shape;
            
            if (shapeType === 'persegi' || shapeType === 'lingkaran' || shapeType === 'segitiga') {
                document.getElementById('group_l').style.display = 'none';
                document.getElementById('label_p').innerHTML = shapeType==='lingkaran' ? 'Diameter (d): <span id="sim_sizeVal">2.0</span>' : 'Panjang Sisi (s): <span id="sim_sizeVal">2.0</span>';
            } else {
                document.getElementById('group_l').style.display = 'block';
                if(shapeType==='persegipanjang') {
                    document.getElementById('label_p').innerHTML = 'Panjang (p): <span id="sim_sizeVal">2.0</span>';
                    document.getElementById('label_l').innerHTML = 'Lebar (l): <span id="sim_lVal">1.5</span>';
                } else if (shapeType==='jajargenjang' || shapeType==='trapesium') {
                    document.getElementById('label_p').innerHTML = 'Alas Bawah (a): <span id="sim_sizeVal">2.0</span>';
                    document.getElementById('label_l').innerHTML = 'Tinggi (t): <span id="sim_lVal">1.5</span>';
                } else {
                    document.getElementById('label_p').innerHTML = 'Diagonal 1 (d1): <span id="sim_sizeVal">2.0</span>';
                    document.getElementById('label_l').innerHTML = 'Diagonal 2 (d2): <span id="sim_lVal">1.5</span>';
                }
            }
            
            // Sync slider teks
            document.getElementById('sim_sizeVal').textContent = document.getElementById('sim_size').value;
            document.getElementById('sim_lVal').textContent = document.getElementById('sim_l').value;
            draw();
        }));

        document.getElementById('sim_size').addEventListener('input', function() {
            const v = parseFloat(this.value).toFixed(1);
            document.getElementById('sim_sizeVal').textContent = v;
            document.getElementById('sim_sizeDisp').textContent = v;
            draw();
        });

        document.getElementById('sim_l').addEventListener('input', function() {
            const v = parseFloat(this.value).toFixed(1);
            document.getElementById('sim_lVal').textContent = v;
            document.getElementById('sim_lDisp').textContent = v;
            draw();
        });

        document.querySelectorAll('.sim-color').forEach(el => el.addEventListener('click', function() {
            document.querySelectorAll('.sim-color').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            color = this.dataset.color;
            draw();
        }));

        document.getElementById('btn_solid').addEventListener('click', function() {
            document.getElementById('btn_wireframe').classList.remove('active');
            this.classList.add('active');
            displayMode = 'solid';
            draw();
        });

        document.getElementById('btn_wireframe').addEventListener('click', function() {
            document.getElementById('btn_solid').classList.remove('active');
            this.classList.add('active');
            displayMode = 'wireframe';
            draw();
        });

        document.getElementById('sim_reset').addEventListener('click', function() {
            document.getElementById('sim_size').value = 2.0;
            document.getElementById('sim_sizeVal').textContent = '2.0';
            document.getElementById('sim_sizeDisp').textContent = '2.0';
            document.getElementById('sim_l').value = 1.5;
            document.getElementById('sim_lVal').textContent = '1.5';
            document.getElementById('sim_lDisp').textContent = '1.5';
            draw();
        });

        document.getElementById('sim_random').addEventListener('click', function() {
            const list = ['persegi','persegipanjang','lingkaran','segitiga','jajargenjang','layanglayang','belahketupat','trapesium'];
            const rShape = list[Math.floor(Math.random() * list.length)];
            
            const randP = (Math.random() * (4.5 - 1.5) + 1.5).toFixed(1);
            const randL = (Math.random() * (3.5 - 1.2) + 1.2).toFixed(1);

            document.getElementById('sim_size').value = randP;
            document.getElementById('sim_l').value = randL;

            const targetBtn = document.querySelector(`.sim-shape[data-shape="${rShape}"]`);
            if (targetBtn) targetBtn.click();
        });

        window.addEventListener('resize', resizeCanvas);
    }

    // Jalankan inisialisasi awal saat DOM siap
    setTimeout(() => {
        resizeCanvas();
        bindEvents();
    }, 100);
})();
</script>