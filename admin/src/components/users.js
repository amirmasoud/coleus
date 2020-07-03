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
  EditButton,
  TextInput,
  BooleanInput,
  NumberInput,
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
      <TextInput source="id" />
      <ImageField source="thumbnail" />
      <TextInput source="name" />
      <TextInput source="username" />
      <TextInput source="email" />
      <TextInput source="status" />
      <BooleanInput source="sticky" />
      <NumberInput source="order" />
      <TextInput multiline source="bio" />
    </SimpleForm>
  </Edit>
);
