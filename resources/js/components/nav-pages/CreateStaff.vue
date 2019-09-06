<template>
    <div class="card text-white bg-gradient-primary border-left-warning">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Staff</h4>
                        </div>
                        <div class="col-6">
                            <button @click="showStaffModal(true)" 
                            class="btn btn-danger btn-sm float-right">
                            <i class="fas fa-plus-circle">
                                </i> New Staff
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- --------------new stafff modal------------------------ -->
        <div class="modal swal2-show" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header py-1">
                        <h5 class="modal-title" id="settingTitle">Staff</h5>
                    </div>
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="row">
                                
                            </div>
                            <button @click="showStaffModal(null)" class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            
        }
    },
    props: {
        currentUser: ''
    },
    methods: {
        showStaffModal(args) {
           if(args){
                $('#staffModal').modal('show');
           }else {
               $('#staffModal').modal('hide');
           }
        }
    }
}
</script>

