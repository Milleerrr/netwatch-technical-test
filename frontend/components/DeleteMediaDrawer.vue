<script lang="ts" setup>
import type { MediaProps } from "@/utils/types";
const axios  = useApi();

const emit = defineEmits(["refresh-data", "update:open"]);
const props = defineProps<{ open: boolean; media?: MediaProps, endpoint: string }>();

const refreshData = () => emit("refresh-data");
const closeDialog = () => emit("update:open", false);

const deleteMedia = async () => {
  await axios.delete<MediaProps>(`${props.endpoint}/${props?.media?.id}`)
  closeDialog();
  refreshData();
};
</script>

<template>
  <AlertDialog
    :open="open"
    @update:open="(openState) => $emit('update:open', openState)"
  >
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This will permanently delete this entry
          and remove your data from the server.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel @click="$emit('update:open', false)"
          >Cancel</AlertDialogCancel
        >
        <Button @click="deleteMedia"> Continue </Button>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
