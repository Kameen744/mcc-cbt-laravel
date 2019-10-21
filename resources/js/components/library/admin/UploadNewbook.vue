<template>
    <div class="card text-white bg-gradient-primary border-left-danger">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>New Resource</h4>
                        </div>
                        <div class="col-md-6">
                            <button @click="showModal(null)" type="button" 
                            class="btn btn-danger btn-sm float-right">
                            <i class="fas fa-plus-circle"></i> Upload New Resource
                            </button>
                        </div>
                    </div>
                    <div class="col-12 p-0 mb-1"><hr class="p-0 m-0 bg-white"></div>
                    <data-table :columns="columns" :key="data_table_key"
                    :classes="classes" url="res_type"></data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    filterable: true,
                },
                {
                    label: 'Title',
                    name: 'title', 
                    filterable: true,
                },
                {
                    label: 'Subject',
                    name: 'subject',
                    filterable: true,
                },
                {
                    label: 'Author',
                    name: 'author',
                    filterable: true,
                },
                {
                    label: '',
                    name: 'View',
                    filterable: false,
                    classes: { 
                        'btn-danger': true,
                    },
                    event: "click",
                    handler: this.viewType,
                    component: DataButtonVue, 
                }
            ],

            editMode: true,
            data_table_key: 1,
            form: new Form({
                res_file: '',
                
            }),
            typeData: {
                res_type: null
            }, 
            errors: [],
            res_type: Object,
            res_types: [],
        }
    }
}
</script>

<style>

</style>