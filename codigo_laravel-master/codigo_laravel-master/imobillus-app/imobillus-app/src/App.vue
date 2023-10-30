<template>
	<div id="app">
		<v-app id="inspire">
			<router-view />
		</v-app>
	</div>
</template>

<script>
import {mapState} from 'vuex'
import {userKey} from '@/global'

export default {
	computed: mapState(['user']),
	data() {
		return {
			validatingToken: true,
		}
	},

	methods: {
		async validateToken() {
			this.validatingToken = true

			const json = localStorage.getItem(userKey)
			const userData = JSON.parse(json)
			this.$store.commit('setUser', null)

			if(!userData) {
				this.validatingToken = false
				//this.$router.push({ path: '/' })
				return
			}

			if(userData) {
				this.$store.commit('setUser', userData)

			}else{
				localStorage.removeItem(userKey)
				//this.$router.push({ path: '/' })
			}

			this.validatingToken = false

		},	 	
	},
	created(){
		this.validateToken()
	},	
}

</script>

<style scoped>
	@import '../src/css/stylesheet.css';
	@import '../src/css/stylesheet2.css';
</style>
