<template>
  <ListComponent :fields="fields" :search-fields="searchFields" :list-api="api.index" :delete-api="api.delete" :has-button="{create: hasCreate, export: true}" />
</template>

<script>
import ResourceApi from '../../api/resourceApi'
import ListComponent from '@/common/components/CRUD/ListComponent'
import { mapGetters } from 'vuex'

const api_roles = new ResourceApi('roles')

export default {
  name: 'UserList',
  components: { ListComponent },
  props: {
    selectRoles: {
      type: Array
    }
  },
  data() {
    const api = new ResourceApi('users')

    return {
		api,
		load_success: false,
		hasButton: {
			create: true,
			export: true
		},
		fields: [
			{
				name: 'id',
				sortField: 'id',
				title: 'Số thứ tự'
			},
			{
				name: 'name',
				sortField: 'name',
				title: 'Họ và tên'
			},
			{
				name: 'gender',
				sortField: 'gender',
				title: 'Giới tính'
			},			
			{
				name: 'phone',
				sortField: 'phone',
				title: 'Số điện thoại'
			},
			{
				name: 'address',
				sortField: 'address',
				title: 'Địa chỉ'
			},
			{
				name: 'email',
				sortField: 'email',
				title: 'Email'
			},
			{
				name: 'role.display_name',
				field: 'role.display_name',
				sort: false,
				title: 'Chức vụ'
			},
			{
				name: '__component:action-column',
				width: '100px',
				title: ''
			}
		],
		searchFields: [
			{
				field: 'username_like',
				title: 'Tên đăng nhập',
				placeholder: 'Nhập tên đăng nhập'
			},
			{
				field: 'full_name_like',
				title: 'Họ và tên',
				placeholder: 'Nhập tên đầy đủ'
			},
			{
				field: 'email_like',
				title: 'Email',
				placeholder: 'abc@gmail.com'
			}
		]
	}
},
computed: {
...mapGetters([
		'role'
	]),
		hasCreate() {
		return true
	}
},
created() {
	this.selectRoles = []
	this.getAllRole()
},
methods: {
	getAllRole() {
		api_roles.index().then(response => {
			for (var i = 0; i < response.data.length; i++) {
				this.selectRoles.push({
					key: response.data[i].name,
					value: response.data[i].display_name
				})
			}

		}).catch(err => {
			console.log(err)
		})
	}
}
}
</script>

