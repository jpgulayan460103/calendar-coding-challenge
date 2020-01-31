<template>
    <div>
        <form id="event_form" @submit.prevent="eventFormSubmit">
            <div class="form-group">
                <label for="event_name">Event</label>
                <input type="text" :class="formValidation('name').className" class="form-control " v-model="eventFormData.name" id="event_name" placeholder="Enter Event Name" name="event_name" autocomplete="off" required>
                <div style="color:red">{{ formValidation('name').feedback }}</div>
            </div>
            <div class="form-row ">
                <div class="col">
                    <label for="event_start_date">From</label>
                    <input type="text" :class="formValidation('start_date').className" class="form-control" v-model="eventFormData.start_date" @change="addStartDate" id="event_start_date" placeholder="Enter Start Date" name="event_start_date" autocomplete="off" readonly required>
                    <div style="color:red">{{ formValidation('start_date').feedback }}</div>
                </div>
                <div class="col">
                    <label for="event_end_date">To</label>
                    <input type="text" :class="formValidation('end_date').className" class="form-control" v-model="eventFormData.end_date" @change="addEndDate" id="event_end_date" placeholder="Enter End Date" name="event_end_date" autocomplete="off" readonly required>
                    <div style="color:red">{{ formValidation('end_date').feedback }}</div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_mon" value="Monday">
                    <label class="form-check-label" for="event_mon">Mon</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_tue" value="Tuesday">
                    <label class="form-check-label" for="event_tue">Tue</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_wed" value="Wednesday">
                    <label class="form-check-label" for="event_wed">Wed</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_thu" value="Thursday">
                    <label class="form-check-label" for="event_thu">Thu</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_fri" value="Friday">
                    <label class="form-check-label" for="event_fri">Fri</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_sat" value="Saturday">
                    <label class="form-check-label" for="event_sat">Sat</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" v-model="eventFormData.event_days" type="checkbox" id="event_sun" value="Sunday">
                    <label class="form-check-label" for="event_sun">Sun</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" :disabled="eventFormSubmitted">Save</button>
        </form>
    </div>
</template>

<script>

    import $ from 'jquery';
    import 'jquery-ui-bundle/jquery-ui.css';
    import 'jquery-ui-bundle/jquery-ui';
    import _debounce from 'lodash/debounce'

    export default {
        props: ['eventFormErrors','isValidated'],
        data() {
            return {
                eventFormData: {
                    name: "",
                    start_date: "",
                    end_date: "",
                    event_days: [],
                },
                eventDetails: {},
                eventFormSubmitted: false,
            }
        },
        mounted() {
            self = this;
            $('#event_end_date').datepicker({
                onSelect: function(date) {
                    self.eventFormData.end_date = date;
                }
            });
            $('#event_start_date').datepicker({
                onSelect: function(date) {
                    self.eventFormData.start_date = date;
                }
            });
        },
        methods: {
            eventFormSubmit: _debounce(function(){
                this.eventFormSubmitted = true;
                this.$API.Event.add(this.eventFormData)
                .then(res => {
                    this.eventFormSubmitted = false;
                    this.eventDetails = res.data.event.details.data;
                    this.$EventDispatcher.fire('SUBMIT_EVENT_FORM', {
                            'status':'success',
                            'event': res.data.event,
                            'errors': {},
                        }
                    );
                    $.notify("Event successfuly saved","success");
                })
                .catch(err => {
                    this.eventFormSubmitted = false;
                    this.$EventDispatcher.fire('SUBMIT_EVENT_FORM', {
                            'status':'error',
                            'errors': err.response.data,
                        }
                    );
                })
                .then(err => {
                    this.eventFormSubmitted = false;
                });
            },250),

            addStartDate(val){
                console.log(val);
            },
            addEndDate(val){
                console.log(val);
            },
            formValidation($field){
                let className = '';
                let feedback = '';
                if(this.eventFormErrors[$field]){
                    feedback = this.eventFormErrors[$field][0];
                    className = 'is-invalid';
                }else{
                    
                }
                return {
                    feedback: feedback,
                    className: className,
                }
            }
        },
    }
</script>
