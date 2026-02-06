<?php include(APPPATH . 'views/_partials/header.php'); ?>
<?php $page_title = "Job Detail";
include(APPPATH . 'views/_partials/topbar.php'); ?>

<div class="container py-3">

  <div class="card shadow-sm border-0">

    <div class="card-body py-2 px-3">

      <!-- HEADER -->
      <div class="d-flex justify-content-between align-items-center mb-1">
        <div class="fw-bold small">
          Cargo #<?= (int)$booking['booking_id'] ?>
        </div>
        <span class="badge bg-success small">
          Active
        </span>
      </div>

      <!-- ROUTE -->
      <div class="text-muted small mb-2">
        <?= htmlspecialchars($booking['loc_from']) ?>
        <span class="mx-1">→</span>
        <?= htmlspecialchars($booking['loc_to']) ?>
      </div>

      <!-- ACCORDION -->
      <div class="accordion accordion-flush" id="statusAccordion">

        <div class="accordion-item">
          <h2 class="accordion-header">

            <button
              class="accordion-button collapsed py-2 px-0 small fw-semibold"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#updateStatus">
              Update Status
            </button>

          </h2>

          <div
            id="updateStatus"
            class="accordion-collapse collapse"
            data-bs-parent="#statusAccordion">

            <div class="accordion-body px-0 pt-2 pb-1">

              <form method="post">

                <!-- STATUS -->
                <div class="mb-2">
                  <label class="form-label small mb-1">
                    Status
                  </label>
                  <select class="form-select form-select-sm" name="status" required>
                    <option value="">Select</option>
                    <option value="accepted">Accepted</option>
                    <option value="picked_up">Picked Up</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="mishap">Mishap</option>
                  </select>
                </div>

                <!-- REMARKS -->
                <div class="mb-2">
                  <label class="form-label small mb-1">
                    Remarks
                  </label>
                  <textarea
                    class="form-control form-control-sm"
                    name="note"
                    rows="2"
                    placeholder="Optional note"></textarea>
                </div>

                <!-- SUBMIT -->
                <button
                  type="submit"
                  name="set_status"
                  class="btn btn-dark btn-sm w-100">
                  Save
                </button>

              </form>

            </div>
          </div>

        </div>

      </div>

    </div>
  </div>

</div>



<?php include(APPPATH . 'views/_partials/bottom_driver.php'); ?>
<?php include(APPPATH . 'views/_partials/footer.php'); ?>