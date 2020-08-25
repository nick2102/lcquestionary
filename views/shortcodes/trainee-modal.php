<!-- The Modal -->
<div class="modal fade" id="<?php echo $data['modalID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $data['modalTitle']; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php echo $data['modalContent']; ?>
            </div>

        </div>
    </div>
</div>
