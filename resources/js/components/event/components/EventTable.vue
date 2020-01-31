<template>
    <div>
        <h1>
            <b>
                <span>{{ event.start_date_formatted }}</span>
                <span v-if="event.start_date_formatted != event.end_date_formatted">
                    - {{ event.end_date_formatted }}
                </span>
            </b>
        </h1>
        <table class="table" v-if="event.details && event.details.data">
            <thead>
                <tr>
                    <th scope="col" style="width:120px"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(eventDetail, index) in event.details.data" :key="index" :class="[eventDetail.has_event ? 'table-success' : '']">
                    <td scope="row">{{ `${eventDetail.event_month} ${eventDetail.event_day}, ${eventDetail.event_day_of_week}` }}</td>
                    <td>
                        <span v-if="eventDetail.has_event">{{ event.name }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props:[
            'event'
        ],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
