import Vue from 'vue'

export default class EventDispacher{
	constructor(){
		this.vue = new Vue()
	}
	fire(event, data = null) {
		this.vue.$emit(event, data)
	}
	listen(event, callback) {
		this.vue.$on(event, callback)
	}

	/*
	** Registered Events
	* - Here lists the current events being used among vue components.
	*
	* [dt]: Brief description of data passed along the fired event; exclude if no data
	* [c]: Components utilizing the event
	*
	*
	* === CLOSE_BOX_MODAL ===
	* Global closing event for vue modals. 
	* [c]: modals/BoxModal; modals/AttributeTemplateModal; modals/NewVariantModal
	*
	* === ADD_NEW_VARIANTS ===
	* Closes New Variant Modal
	* [c]: modals/NewVariantModal - [dt] newly added variants
	*/
}
