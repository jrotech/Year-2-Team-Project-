import React from 'react';
import { useForm } from '@mantine/form';
import { TextInput, Button, Stack, Flex } from '@mantine/core';


export default function PersonalDetails({}){
  const form = useForm({
    initialValues: {
      first_name: '',
      last_name: '',
      address: '',
      postal_code: '',
      email: '',
      phone_number: '',
    },
    validate: {
      first_name: (value) => value.trim().length > 0 ? null : 'First name is required',
      last_name: (value) => value.trim().length > 0 ? null : 'Last name is required',
      address: (value) => value.trim().length > 0 ? null : 'Address is required',
      postal_code: (value) => value.trim().length > 0 ? null : 'Postal code is required',
      email: (value) => value.trim().length > 0 ? null : 'Email is required',
      phone_number: (value) => value.trim().length > 0 ? null : 'Phone number is required',
    },
  });

  const handleSubmit = ( values ) => {
    console.log(values);
  }

  return (
    <Stack>
      <form onSubmit={form.onSubmit(console.log('yes'))} className="flex gap-y-4 flex-col">
	<Flex gap="10" className="items-stretch justify-stretch">
	  <TextInput {...form.getInputProps("first_name")} label="First Name" required/>
	  <TextInput {...form.getInputProps("last_name")} label="Last Name" required/>
	</Flex>
	<TextInput {...form.getInputProps("address")} label="Address"  required />
	<TextInput {...form.getInputProps("postal_code")} label="Postal Code" required />
	<Flex gap="10">
	  <TextInput {...form.getInputProps("email")} label="Email" required />
	  <TextInput {...form.getInputProps("phone_number")} label="Phone Number"  required />
	</Flex>
	<Button type="submit" mt="10">Next</Button>
      </form>
    </Stack>
  )

}
