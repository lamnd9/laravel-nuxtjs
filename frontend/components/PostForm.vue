<template>
  <form @submit.prevent="onSubmit">
    <h2 class="mt-4">{{ localForm.id ? 'Cập nhật' : 'Thêm mới' }}</h2>

    <div class="mb-3">
      <label class="form-label">Tiêu đề</label>
      <input v-model="localForm.title" type="text" class="form-control" required />
      <div v-if="errors.title" class="text-danger small">{{ errors.title[0] }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nội dung</label>
      <textarea v-model="localForm.content" class="form-control" rows="4" required></textarea>
      <div v-if="errors.content" class="text-danger small">{{ errors.content[0] }}</div>
    </div>

    <div class="mb-3">
      <label>Lượt xem</label>
      <input v-model="localForm.views" type="number" class="form-control" />
      <div v-if="errors.views" class="text-danger small">{{ errors.views[0] }}</div>
    </div>

    <div class="mb-3">
      <label>Bắt đầu</label>
      <input v-model="localForm.start_at" type="datetime-local" class="form-control" />
      <div v-if="errors.start_at" class="text-danger small">{{ errors.start_at[0] }}</div>
    </div>

    <div class="mb-3">
      <label>Kết thúc</label>
      <input v-model="localForm.end_at" type="datetime-local" class="form-control" />
      <div v-if="errors.end_at" class="text-danger small">{{ errors.end_at[0] }}</div>
    </div>

    <button type="submit" class="btn btn-success">
      {{ localForm.id ? 'Cập nhật' : 'Thêm mới' }}
    </button>

    <button v-if="localForm.id" type="button" class="btn btn-secondary ms-2" @click="emit('reset')">Huỷ</button>
  </form>
</template>

<script setup lang="ts">
const props = defineProps<{
  form: { id: number | null; title: string; content: string; views: number; start_at: string; end_at: string };
}>()
const errors = ref<Record<string, string[]>>({})

const emit = defineEmits(['submit', 'reset'])

const localForm = ref({ ...props.form })

watch(() => props.form, (newForm) => {
  localForm.value = { ...newForm }
})

const onSubmit = async () => {
  try {
    await emit('submit', localForm.value)
    errors.value = {}
  } catch (error: any) {
    if (error?.data?.errors) {
      errors.value = error.data.errors
    }
  }
}
</script>
