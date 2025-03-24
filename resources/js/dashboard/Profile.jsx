/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react'
import { Stack, Avatar, Title, Flex, Center } from '@mantine/core'

export default function Profile(props){
  return (
    <Flex className="bg-white rounded-md p-10 gap-24  flex-col md:flex-row md:justify-normal justify-center">
      <Center>
	<Avatar radius="xl" size="xl" />
      </Center>
      <Stack>
	<Title order={4}>Full Name: {props.name}</Title>
	<Title order={4}>Email: {props.email}</Title>
	<Title order={4}>Phone: {props.phone}</Title>
	<Title order={4}>Address: {props.address}</Title>
      </Stack>
      <Stack>
	<Title order={4}>Total Orders: {props.orders}</Title>
	<Title order={4}>Total Spent: {props.spent}</Title>
	<Title order={4}>Total Points: {props.points}</Title>
      </Stack>
    </Flex>
  )
}
