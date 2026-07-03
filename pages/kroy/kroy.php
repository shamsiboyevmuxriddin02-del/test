<?php
// =====================================================
//  KROY (kesish) bo'limi sahifasi
//  index.php ichidagi #content_body ga yuklanadigan fragment
// =====================================================
?>

<div class="container-fluid py-3">

    <!-- ============ SARLAVHA ============ -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-scissors me-2"></i> Kroy bo'limi
        </h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_product_kroy_modal">
            <i class="bi bi-plus-lg me-1"></i> Yangi kroy
        </button>
    </div>

    <!-- ============ KPI KARTALAR ============ -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="bi bi-scissors fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Oxirgi oy kroylari</div>
                        <div class="fs-4 fw-bold" id="kpi_kroy_month">0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="bi bi-bag-check fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Oxirgi oy modellari</div>
                        <div class="fs-4 fw-bold" id="kpi_models_month">0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                        <i class="bi bi-rulers fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Sarflangan mato (m)</div>
                        <div class="fs-4 fw-bold" id="kpi_fabric_month">0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                        <i class="bi bi-trophy fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Eng ko'p model</div>
                        <div class="fs-6 fw-bold text-truncate" id="kpi_top_model" style="max-width:160px;">-</div>
                        <div class="text-muted small" id="kpi_top_model_qty"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ TREND CHART ============ -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="card-title mb-3">
                <i class="bi bi-graph-up me-1"></i> Oxirgi 6 oy dinamikasi
            </h6>
            <canvas id="cuttingTrendChart" height="90"></canvas>
        </div>
    </div>

    <!-- ============ JADVAL ============ -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="cuttingTable" class="table table-hover table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kroy raqami</th>
                            <th>Model</th>
                            <th>O'lchamlar</th>
                            <th>Soni</th>
                            <th>Mato tarkibi</th>
                            <th>Qatlam (m x soni)</th>
                            <th>Sarflangan mato (m)</th>
                            <th>Eni / Gramm</th>
                            <th>Sana</th>
                            <th>Rasm</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<!-- ================== YANGI KROY MODAL ================== -->
<div class="modal fade" id="add_product_kroy_modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form id="add_product_form" enctype="multipart/form-data">

                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <i class="bi bi-scissors me-2"></i> Kroy ma'lumotlari
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="formAlert" class="alert d-none"></div>

                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Kroy raqami</label>
                            <input type="text" name="kroy_number" class="form-control" placeholder="KR-001">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Qatlam uzunligi (m)</label>
                            <input type="number" step="0.01" name="layer_length" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Qatlam soni</label>
                            <input type="number" name="layer_count" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Mato tarkibi</label>
                            <select class="form-select" name="composition">
                                <option value="Cotton 100%">Cotton 100%</option>
                                <option value="Polyestr 100%">Polyestr 100%</option>
                                <option value="Cotton/Polyestr">Cotton/Polyestr</option>
                                <option value="Polyestr/Viskoz">Polyestr/Viskoz</option>
                                <option value="Pryaja krash">Pryaja krash</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Foiz (%)</label>
                            <input type="text" name="percentage" class="form-control" placeholder="65/35">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Grami (g/m2)</label>
                            <input type="number" name="gramm" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Eni (sm)</label>
                            <input type="number" name="width" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Model nomi</label>
                            <input type="text" name="model_name" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">O'lchamlar</label>
                            <input type="text" name="sizes" class="form-control" placeholder="S,M,L,XL">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Model soni</label>
                            <input type="number" name="quantity" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Sana</label>
                            <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Rasm</label>
                            <div class="image-upload-mini border rounded p-3 text-center" id="imageUpload" style="cursor:pointer;">
                                <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                                <div id="uploadText">
                                    <i class="bi bi-camera fs-3 text-secondary"></i>
                                    <div class="small text-muted">Rasm tanlash</div>
                                </div>
                                <img id="imagePreview" class="img-fluid d-none mt-2 rounded" style="max-height:120px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Yopish</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i> Saqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ================== TAHRIRLASH MODAL ================== -->
<div class="modal fade" id="edit_product_kroy_modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form id="edit_product_form" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">

                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i> Kroyni tahrirlash
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="editFormAlert" class="alert d-none"></div>

                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Kroy raqami</label>
                            <input type="text" name="kroy_number" id="edit_kroy_number" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Qatlam uzunligi (m)</label>
                            <input type="number" step="0.01" name="layer_length" id="edit_layer_length" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Qatlam soni</label>
                            <input type="number" name="layer_count" id="edit_layer_count" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Mato tarkibi</label>
                            <select class="form-select" name="composition" id="edit_composition">
                                <option value="Cotton 100%">Cotton 100%</option>
                                <option value="Polyestr 100%">Polyestr 100%</option>
                                <option value="Cotton/Polyestr">Cotton/Polyestr</option>
                                <option value="Polyestr/Viskoz">Polyestr/Viskoz</option>
                                <option value="Pryaja krash">Pryaja krash</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Foiz (%)</label>
                            <input type="text" name="percentage" id="edit_percentage" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Grami (g/m2)</label>
                            <input type="number" name="gramm" id="edit_gramm" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Eni (sm)</label>
                            <input type="number" name="width" id="edit_width" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Model nomi</label>
                            <input type="text" name="model_name" id="edit_model_name" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">O'lchamlar</label>
                            <input type="text" name="sizes" id="edit_sizes" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Model soni</label>
                            <input type="number" name="quantity" id="edit_quantity" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Sana</label>
                            <input type="date" name="date" id="edit_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Rasm (yangilash uchun)</label>
                            <div class="image-upload-mini border rounded p-3 text-center" id="editImageUpload" style="cursor:pointer;">
                                <input type="file" name="image" id="editImageInput" accept="image/*" hidden>
                                <div id="editUploadText">
                                    <i class="bi bi-camera fs-3 text-secondary"></i>
                                    <div class="small text-muted">Rasm tanlash</div>
                                </div>
                                <img id="editImagePreview" class="img-fluid d-none mt-2 rounded" style="max-height:120px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Yopish</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Yangilash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {

    // ============ RASM PREVIEW (qo'shish) ============
    $("#imageUpload").on("click", function () { $("#imageInput").click(); });
    $("#imageInput").on("change", function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (ev) {
                $("#imagePreview").attr("src", ev.target.result).removeClass("d-none");
                $("#uploadText").hide();
            };
            reader.readAsDataURL(file);
        }
    });

    // ============ RASM PREVIEW (tahrir) ============
    $("#editImageUpload").on("click", function () { $("#editImageInput").click(); });
    $("#editImageInput").on("change", function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (ev) {
                $("#editImagePreview").attr("src", ev.target.result).removeClass("d-none");
                $("#editUploadText").hide();
            };
            reader.readAsDataURL(file);
        }
    });

    // ============ DATATABLE ============
    let cuttingTable = $('#cuttingTable').DataTable({
        ajax: {
            url: "api/cutting/fetch_cutting.php",
            dataSrc: "data"
        },
        order: [[0, 'desc']],
        columns: [
            { data: 'id' },
            { data: 'kroy_number' },
            { data: 'model_name' },
            { data: 'sizes' },
            { data: 'quantity' },
            { data: 'composition' },
            {
                data: null,
                render: function (row) {
                    let len = row.layer_length ?? '-';
                    let cnt = row.layer_count ?? '-';
                    return len + ' x ' + cnt;
                }
            },
            { data: 'fabric_used' },
            {
                data: null,
                render: function (row) {
                    return (row.width ?? '-') + ' sm / ' + (row.gramm ?? '-') + ' g';
                }
            },
            { data: 'cut_date' },
            {
                data: 'image',
                orderable: false,
                render: function (img) {
                    if (img) {
                        return '<img src="uploads/cutting/' + img + '" style="width:45px;height:45px;object-fit:cover;border-radius:6px;">';
                    }
                    return '<span class="text-muted small">yo\'q</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function (id) {
                    return `
                        <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${id}"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${id}"><i class="bi bi-trash"></i></button>
                    `;
                }
            }
        ],
        language: {
            emptyTable: "Ma'lumot yo'q",
            search: "Qidirish:",
            lengthMenu: "_MENU_ ta ko'rsatish",
            info: "_TOTAL_ tadan _START_-_END_",
            infoEmpty: "0 ta yozuv",
            paginate: { first: "Birinchi", last: "Oxirgi", next: "Keyingi", previous: "Oldingi" }
        }
    });

    // ============ STATISTIKA YUKLASH ============
    let trendChart = null;
    function loadStats() {
        $.getJSON("api/cutting/cutting_stats.php", function (res) {
            if (res.status !== "success") return;

            $("#kpi_kroy_month").text(res.kpi.kroy_month);
            $("#kpi_models_month").text(res.kpi.models_month);
            $("#kpi_fabric_month").text(res.kpi.fabric_month);
            $("#kpi_top_model").text(res.kpi.top_model);
            $("#kpi_top_model_qty").text(res.kpi.top_model_qty > 0 ? res.kpi.top_model_qty + " dona" : "");

            // Chart
            let ctx = document.getElementById('cuttingTrendChart').getContext('2d');
            if (trendChart) trendChart.destroy();
            trendChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: res.trend.labels,
                    datasets: [
                        {
                            label: 'Kroylar soni',
                            data: res.trend.kroy,
                            backgroundColor: 'rgba(13,110,253,0.6)',
                            borderRadius: 6
                        },
                        {
                            label: 'Modellar soni',
                            data: res.trend.models,
                            backgroundColor: 'rgba(25,135,84,0.6)',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    }
    loadStats();

    // ============ QO'SHISH ============
    $("#add_product_form").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "api/cutting/add_cutting_product.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.status === "success") {
                    $("#formAlert").removeClass("d-none alert-danger").addClass("alert-success").text(data.message);
                    $("#add_product_form")[0].reset();
                    $("#imagePreview").addClass("d-none");
                    $("#uploadText").show();
                    cuttingTable.ajax.reload(null, false);
                    loadStats();
                    setTimeout(function () {
                        bootstrap.Modal.getInstance(document.getElementById('add_product_kroy_modal')).hide();
                        $("#formAlert").addClass("d-none");
                    }, 900);
                } else {
                    $("#formAlert").removeClass("d-none alert-success").addClass("alert-danger").text(data.message);
                }
            },
            error: function () {
                $("#formAlert").removeClass("d-none alert-success").addClass("alert-danger").text("Server bilan bog'lanishda xatolik");
            }
        });
    });

    // ============ TAHRIRLASH: ma'lumotni yuklash ============
    $('#cuttingTable tbody').on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        $.getJSON("api/cutting/get_cutting.php?id=" + id, function (res) {
            if (res.status !== "success") { alert(res.message); return; }
            let d = res.data;
            $("#edit_id").val(d.id);
            $("#edit_kroy_number").val(d.kroy_number);
            $("#edit_layer_length").val(d.layer_length);
            $("#edit_layer_count").val(d.layer_count);
            $("#edit_composition").val(d.composition);
            $("#edit_percentage").val(d.percentage);
            $("#edit_gramm").val(d.gramm);
            $("#edit_width").val(d.width);
            $("#edit_model_name").val(d.model_name);
            $("#edit_sizes").val(d.sizes);
            $("#edit_quantity").val(d.quantity);
            $("#edit_date").val(d.cut_date);

            // Mavjud rasmni ko'rsatish
            if (d.image) {
                $("#editImagePreview").attr("src", "uploads/cutting/" + d.image).removeClass("d-none");
                $("#editUploadText").hide();
            } else {
                $("#editImagePreview").addClass("d-none");
                $("#editUploadText").show();
            }
            $("#editImageInput").val("");
            new bootstrap.Modal(document.getElementById('edit_product_kroy_modal')).show();
        });
    });

    // ============ TAHRIRLASH: yuborish ============
    $("#edit_product_form").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "api/cutting/update_cutting.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.status === "success") {
                    $("#editFormAlert").removeClass("d-none alert-danger").addClass("alert-success").text(data.message);
                    cuttingTable.ajax.reload(null, false);
                    loadStats();
                    setTimeout(function () {
                        bootstrap.Modal.getInstance(document.getElementById('edit_product_kroy_modal')).hide();
                        $("#editFormAlert").addClass("d-none");
                    }, 900);
                } else {
                    $("#editFormAlert").removeClass("d-none alert-success").addClass("alert-danger").text(data.message);
                }
            },
            error: function () {
                $("#editFormAlert").removeClass("d-none alert-success").addClass("alert-danger").text("Server bilan bog'lanishda xatolik");
            }
        });
    });

    // ============ O'CHIRISH ============
    $('#cuttingTable tbody').on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        if (!confirm("Ushbu kroy yozuvini o'chirmoqchimisiz?")) return;

        $.ajax({
            url: "api/cutting/delete_cutting.php",
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function (data) {
                if (data.status === "success") {
                    cuttingTable.ajax.reload(null, false);
                    loadStats();
                } else {
                    alert(data.message);
                }
            }
        });
    });

});
</script>
