<template>
<div>
    <div v-for="(data, index) in parsedData">
        <div class="form-group">
            <label class="col-sm-2 control-label">Extra:</label>
            <div class="col-sm-5">
                <input type="text" name="extra[]" class="form-control" dir="auto" :value="index">
            </div>
            <div class="col-sm-5">
                <input type="text" name="extra[]" class="form-control" dir="auto" :value="data">
            </div>
        </div>
    </div>
    <div v-for="n in count">
        <div class="form-group">
            <label class="col-sm-2 control-label">Extra:</label>
            <div class="col-sm-5">
                <input type="text" name="extra[]" class="form-control" dir="auto">
            </div>
            <div class="col-sm-5">
                <input type="text" name="extra[]" class="form-control" dir="auto">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button class="col-btn bg-purple btn btn-sm" 
                    type="button"
                    @click="extendRangeByOne">Add</button>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data: function () {
            return {
                count: 0,
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
        computed: {
            parsedData: function () {
                return JSON.parse(this.data);
            }
        },
        methods: {
            extendRangeByOne: function () {
                console.log(this.count)
                this.count += 1
            }
        }
    }
</script>