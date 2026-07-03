<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">  
    <div class="modal-content">
      <form id="editForm">
        <div class="modal-header">
          <h5 class="modal-title">✏️ Qurilmani tahrirlash</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-2">
            <label>Kategoriya</label>
            <input type="text" name="category" id="edit_category" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Nomi</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Turi</label>
            <input type="text" name="type" id="edit_type" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Soni</label>
            <input type="number" name="quantity" id="edit_quantity" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Holati</label>
            <select name="status" id="edit_status" class="form-control" required>
              <option value="yaxshi">Yaxshi</option>
              <option value="nosoz">Nosoz</option>
              <option value="ta’mirda">Ta’mirda</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Narx turi</label>
            <select name="price_type" id="edit_price_type" class="form-control" required>
              <option value="kunlik">Kunlik</option>
              <option value="soatlik">Soatlik</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Narx</label>
            <input type="number" name="price" id="edit_price" step="0.01" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Jihoz tannarxi</label>
            <input type="number" name="body_price" id="edit_body_price" step="0.01" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Izoh</label>
            <textarea name="note" id="edit_note" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Yangilash</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        </div>
      </form>
    </div>
  </div>
</div>
