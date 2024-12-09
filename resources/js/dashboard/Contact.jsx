/********************************
Developer: Mihail Vacarciuc
University ID: 230238428
********************************/
import React from 'react'
import { Stack, Avatar, Title, Flex, CopyButton, ActionIcon, Tooltip, rem, Input, NumberInput } from '@mantine/core'

export default function Contact(props){
  return (
    <Stack>
      <Title order={1} className="text-center my-12">Contact</Title>
    <Flex className="rounded-md p-10 gap-24 border-black border-2">
      <Stack>
	<Flex gap="20">
	  <Avatar radius="xl" size="lg" />
	  <Avatar radius="xl" size="lg" />
	  <Avatar radius="xl" size="lg" />
	</Flex>
	<Flex justify="center" gap="20">
	  <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
	  <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
	</Flex>
	
	<Flex align="center" gap="5">
	  <CopyButton value={props.phone_number} timeout={2000} className="mx-4">
	    {({ copied, copy }) => (
              <Tooltip label={copied ? 'Copied' : 'Copy'} withArrow position="right">
		<ActionIcon color={copied ? 'teal' : 'gray'} variant="subtle" onClick={copy}>
		  {copied ? (
		    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
		  ) : (
		    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg>
		  )}
		</ActionIcon>
              </Tooltip>
	    )}
	  </CopyButton>
	  <NumberInput
	    disabled={true}
	    placeholder="Enter your phone number"
	    defaultValue={props.phone_number}
	    rightSection={<></>}/>
	</Flex>
      </Stack>
      <Stack>
	<Title order={4}>Full Name: {props.name}</Title>
	<Title order={4}>Email: {props.email}</Title>
	<Title order={4}>Phone: {props.phone}</Title>
	<Title order={4}>Address: {props.address}</Title>
      </Stack>
    </Flex>
    </Stack>
  )
}
