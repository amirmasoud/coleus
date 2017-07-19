<template>
<div>
    <div class="form-group">
        <div class="col-md-2 hidden-sm hidden-xs"></div>
        <div class="col-md-5">
            <button class="col-btn bg-purple btn btn-sm btn-block" 
                    type="button"
                    @click="increase">Add</button>
        </div>
        <div class="col-sm-5">
            <button type="button" 
                    class="btn btn-sm btn-warning btn-block"
                    @click="decrease"><i class="fa fa-minus"></i> Pop</button>
        </div>
    </div>
    <div v-for="(data, index) in extraData">
        <div class="form-group">
            <div class="col-sm-2">
                <input type="text" name="extra[]" class="form-control" dir="auto" :value="data[0]">
            </div>
            <div class="col-sm-9">
                <input type="text" name="extra[]" class="form-control" dir="auto" :value="data[1]">
            </div>
            <div class="col-sm-1">
                <button type="button" 
                        class="btn btn-warning pull-left"
                        @click="removeExistingItems(index)"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
    <div v-for="(item, index) in toAdd">
        <div class="form-group">
            <div class="col-sm-2">
                <input type="text" name="extra[]" class="form-control" dir="auto" v-model="inputName">
            </div>
            <div class="col-sm-10">
                <input v-if="inputName == 'file'" type="file" name="extra[]" class="form-control">
                <input v-else type="text" name="extra[]" class="form-control">
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data: function () {
            return {
                toAdd: [],
                extraData: [],
                inputName: '',
            }
        },
        props: {
            range: {
                type: String,
                default: 0
            },
            data: {
                type: String
            }
        },
        mounted: function () {
            var json = JSON.parse(this.data)
            this.extraData = Object.keys(json).map(function(key){
                return [key,json[key]]
            });

        },
        methods: {
            increase: function () {
                this.toAdd.push([])
            },
            decrease: function () {
                this.toAdd.pop()
            },
            removeExistingItems: function (index) {
                this.extraData.splice(index, 1)
            }
        }
    }
</script>