<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Calendar</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <event-form :event-form-errors="eventFormErrors.errors" :is-validated="isEventFormValidated"/>
                    </div>
                    <div class="col-md-8">
                        <event-table :event="event" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventForm from './components/EventForm'
    import EventTable from './components/EventTable'
    export default {
        props: ['latestEvent'],
        components: {
            'event-form' : EventForm,
            'event-table' : EventTable,
        },
        data(){
            return {
                event: {},
                eventFormErrors: {
                    errors: {}
                },
                isEventFormValidated: false,
            }
        },
        mounted() {
            this.$EventDispatcher.listen('SUBMIT_EVENT_FORM', (eventFormStatus) => {
                this.isEventFormValidated = true;
                if(eventFormStatus.status == "success"){
                    this.event = eventFormStatus.event;
                }else{
                    this.eventFormErrors = eventFormStatus.errors;
                }
            });
            this.event = this.latestEvent;
        }
    }
</script>
<style lang="scss" scoped>
    .container-fluid{
        margin: 10px;
    }
</style>
