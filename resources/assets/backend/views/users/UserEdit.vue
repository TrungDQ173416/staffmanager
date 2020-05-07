<template>
  <div class="createPost-container">
    <ElForm ref="postForm" :model="model" class="form-container" autocomplete="off" label-width="150px">
      <ElRow :gutter="20">
        <ElCol :md="12">
          <input autocomplete="off" name="hidden-pass" type="password" style="position:absolute; top:-100px">
          <input autocomplete="off" name="hidden-name" type="text" style="position:absolute; top:-100px">
          <ElFormItem prop="name" :error="errors.full_name" label="Họ và tên">
            <ElInput v-model="model.name" />
          </ElFormItem>
          <ElFormItem prop="gender" :error="errors.full_name" label="Giới tính">
            <ElInput v-model="model.gender" />
          </ElFormItem>
          <ElFormItem prop="phone" :error="errors.phone" label="Số điện thoại">
            <ElInput v-model="model.phone" />
          </ElFormItem>
          <ElFormItem prop="address" :error="errors.address" label="Địa chỉ">
            <ElInput v-model="model.address" />
          </ElFormItem>
        </ElCol>
        <ElCol :md="12">
          <ElFormItem prop="email" :error="errors.email" class="is-required" label="Email">
            <ElInput v-model="model.email" />
          </ElFormItem>
          <ElFormItem prop="username" :error="errors.username" class="is-required" label="Tên đăng nhập">
            <ElInput v-model="model.username" />
          </ElFormItem>
          <ElFormItem prop="password" :error="errors.password" :class="isEdit ? '' : 'is-required'" label="Mật khẩu">
            <ElInput v-model="model.password" type="password" />
          </ElFormItem>
        </ElCol>
      </ElRow>
      <ElButton type="primary" @click="updateUser">
        {{ isEdit ? 'Cập nhật' : 'Tạo' }}
      </ElButton>
    </ElForm>
  </div>
</template>

<script>
import ResourceApi from '../../api/resourceApi'
import ListComponent from '@/common/components/CRUD/ListComponent'
import { mapGetters } from 'vuex'
const api = new ResourceApi('users')
const api_roles = new ResourceApi('roles')

const defaultForm = {
  id: undefined,
  name: '',
  gender: '',
  phone: '',
  address: '',
  username: '',
  email: '',
  password: '',
}

export default {
  name: 'UserEdit',
  components: { ListComponent },
  props: {
    isEdit: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      model: Object.assign({}, defaultForm),
      loading: false,
      updateApi: Function,
      errors: {},
      roles: [],
    }
  },
  computed: {
    ...mapGetters([
      'role'
    ]),
  },
  created() {
    if (this.isEdit) {
      const id = this.$route.params && this.$route.params.id
      this.updateApi = api.edit
      this.fetchData(id)
    } else {
      this.model = Object.assign({}, defaultForm)
      this.updateApi = api.create
    }
    this.getAllRole()
    if (this.role.level >= 9) this.getAllCenter()
  },
  methods: {
    fetchData(id) {
      api.show({ id }).then(response => {
        this.model = response.data
        this.model.role = this.model.role || {}
      }).catch(err => {
        console.log(err)
      })
    },
    updateUser() {
      this.loading = true
      this.updateApi(this.model).then(response => {
        this.$router.push('/users/')
      }).catch(err => {
        if (err.response && err.response.data) {
          this.errors = err.response.data.errors
        }
      }).finally(() => {
        this.loading = false
      })
    },
    getAllRole() {
      api_roles.index().then(response => {
        this.roles = response.data
      }).catch(err => {
        console.log(err)
      })
    },
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  @import "~@/backend/styles/mixin.scss";
  .createPost-container {
		position: relative;
		.postInfo-container {
			position: relative;
			@include clearfix;
			margin-bottom: 10px;
			.postInfo-container-item {
				float: left;
			}
		}
    .word-counter {
      width: 40px;
      position: absolute;
      right: -10px;
      top: 0;
    }
  }
</style>
