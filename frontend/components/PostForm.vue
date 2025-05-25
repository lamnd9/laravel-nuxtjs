<template>
  <form @submit.prevent="onSubmit">
    <h2 class="mt-4">{{ localForm.id ? 'Cập nhật' : 'Thêm mới' }}</h2>

    <div class="mb-3">
      <label class="form-label">Tiêu đề</label>
      <input v-model="localForm.title" type="text" class="form-control" required />
    </div>

    <div class="mb-3">
      <label class="form-label">Nội dung</label>
      <textarea v-model="localForm.content" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">
      {{ localForm.id ? 'Cập nhật' : 'Thêm mới' }}
    </button>

    <button v-if="localForm.id" type="button" class="btn btn-secondary ms-2" @click="emit('reset')">Huỷ</button>
  </form>
</template>

<script setup lang="ts">
const props = defineProps<{
  form: { id: number | null; title: string; content: string }
}>()

const emit = defineEmits(['submit', 'reset'])

const localForm = ref({ ...props.form })

watch(() => props.form, (newForm) => {
  localForm.value = { ...newForm }
})

function onSubmit() {
  emit('submit', localForm.value)
}
</script>
