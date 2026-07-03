<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="equipmentForm">
        <div class="modal-header">
          <h5 class="modal-title">Mahsulot qo‘shish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-2">
            <label>Kategoriya</label>
            <input type="text" name="category" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Nomi</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Turi (modeli)</label>
            <input type="text" name="type" class="form-control" >
          </div>
          <div class="mb-2">
            <label>Soni</label>
            <input type="number" name="quantity" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Holati</label>
            <select name="status" class="form-control" >
              <option value="yaxshi">Yaxshi</option>
              <option value="nosoz">Nosoz</option>
              <option value="ta’mirda">Ta’mirda</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Narx turi</label>
            <select name="price_type" class="form-control" required>
              <option value="kunlik">Kunlik</option>
              <option value="soatlik">Soatlik</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Ijara narxi</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>JIhoz tan narxi</label>
            <input type="number" name="price_device" step="0.01" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Izoh</label>
            <textarea name="note" class="form-control"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Saqlash</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS (modal ishlashi uchun kerak) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
