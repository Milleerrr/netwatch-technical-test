<script setup lang="ts">
import type { MediaProps } from "@/utils/types";
const axios  = useApi();

type PickedProps = "title" | "description" | "release_date";
interface CustomMediaProps extends Pick<MediaProps, PickedProps> {
}

const props = defineProps<{ open: boolean; media: MediaProps, endpoint: string }>();
const emit = defineEmits(["update:open", "refresh-data"]);

let form = reactive<CustomMediaProps>({
  title: "",
  description: "",
  release_date: "",
});
const isSubmitting = ref(false);

const addNewBook = async (data: any) => {
  const response = await axios.post(props.endpoint, data)

  return response.data;
};

onMounted(() => {
  if (props.media) {
    form = props.media;
  }
  console.log(props.media)
});

const editMedia = async () => {
  try {
    isSubmitting.value = true;

    const resp = await axios.put<MediaProps>(`${props.endpoint}/${props.media.id}`, form)
    closeDrawer(false);
    emit("refresh-data");
  } catch (error) {
    console.log(error);
  } finally {
    isSubmitting.value = false;
  }
};

const onSubmit = async () => {
  try {
    const formData = new FormData();
    Object.keys(form).forEach((key) => {
      // @ts-ignore
      if (form[key]) {
        formData.append(key, form[key as never]);
      }
    });
    isSubmitting.value = true;
    const data = await addNewBook(formData);
    closeDrawer(false);
    emit("refresh-data");
  } catch (error) {
    console.log(error);
  } finally {
    isSubmitting.value = false;
  }
};

const closeDrawer = (openState: boolean) => emit("update:open", openState);
</script>

<template>
  <Sheet :open="open" @update:open="closeDrawer">
    <SheetContent class="w-full bg-white">
      <SheetHeader>
        <SheetTitle>
          <template v-if="media"> Edit</template>
          <template v-else>Add</template>
        </SheetTitle>
        <SheetDescription>
          Make changes here. Click save when you're done.
        </SheetDescription>
      </SheetHeader>
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="title" class="text-right"> Title </Label>
          <Input
            v-model:model-value="form.title"
            type="text"
            id="title"
            class="col-span-3"
            required
          />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="description" class="text-right"> Description </Label>
          <Input
            v-model:model-value="form.description"
            type="text"
            id="description"
            class="col-span-3"
            required
          />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="release_date" class="text-right">
            Release Date
          </Label>
          <Input
            v-model:model-value="form.release_date"
            type="date"
            id="release_date"
            class="col-span-3"
            required
          />
        </div>
      </div>
      <SheetFooter>
        <Button
          type="submit"
          @click="() => (media?.id ? editMedia() : onSubmit())"
        >
          <template v-if="isSubmitting">Saving...</template>
          <template v-else> Save changes </template>
        </Button>
      </SheetFooter>
    </SheetContent>
  </Sheet>
</template>
