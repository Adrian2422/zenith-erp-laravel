<script setup lang="ts">
  import AuthLayout from '@/layouts/AuthLayout.vue'
  import { store } from '@/routes/password/confirm'
  import { Form, Head } from '@inertiajs/vue3'
</script>

<template>
  <AuthLayout title="Confirm your password" description="This is a secure area of the application. Please confirm your password before continuing.">
    <Head title="Confirm password" />

    <Form v-slot="{ errors, processing }" v-bind="store.form()" reset-on-success>
      <div class="space-y-6">
        <UFormField name="password" :error="errors.password" label="Password">
          <UInput type="password" class="w-full" autocomplete="current-password" autofocus required />
        </UFormField>

        <div class="flex items-center">
          <UButton :loading="processing" type="submit" block>Confirm Password</UButton>
        </div>
      </div>
    </Form>
  </AuthLayout>
</template>
