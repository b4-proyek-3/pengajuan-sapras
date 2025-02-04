<div class="modal fade overflow-y-auto" id="timeSlotsModal" tabindex="-1" aria-labelledby="timeSlotsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeSlotsModalLabel">Detail Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="selectedDateLabel"></h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="timeSlotsTable"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button id="prevDateButton" class="btn btn-primary">Prev</button>
                <button id="nextDateButton" class="btn btn-primary">Next</button>
            </div>
        </div>
    </div>
</div>
