import React from "react";
import {
  List,
  Edit,
  Datagrid,
  SimpleForm,
  TextField,
  EmailField,
  BooleanField,
  NumberField,
  ImageField,
  DateField,
  EditButton,
  TextInput,
  BooleanInput,
  NumberInput,
  SelectInput,
} from "react-admin";

export const UserList = (props) => (
  <List {...props}>
    <Datagrid rowClick="edit">
      <TextField source="id" />
      <ImageField source="thumbnail" />
      <TextField source="name" />
      <TextField source="username" />
      <EmailField source="email" />
      <TextField source="status" />
      <BooleanField source="sticky" />
      <NumberField source="order" />
    </Datagrid>
  </List>
);

export const UserEdit = (props) => (
  <Edit {...props}>
    <SimpleForm rowClick="edit">
      <DateField source="created_at" showTime />
      <ImageField source="medium" />
      <TextInput source="id" />
      <TextInput source="name" />
      <TextInput source="username" />
      <TextInput source="email" />
      <TextInput source="website" />
      <SelectInput
        source="status"
        choices={[
          { id: "open", name: "Open" },
          { id: "locked", name: "Locked" },
          { id: "banned", name: "Banned" },
        ]}
      />
      <BooleanInput source="sticky" />
      <NumberInput source="order" />
      <TextInput multiline source="bio" />
    </SimpleForm>
  </Edit>
);
