//
// THIS COMPONENT USES MANTINE MAKE SURE THE COMPONENT HAS ACCESS TO MANTINE PROVIDER!!!!
//

import React from 'react'
import { Stack, RangeSlider, Title, Checkbox } from '@mantine/core'
import {Stars} from '../components/Stars'

export default function Sidebar(){
  return (
    <Stack className="max-w-[500px] min-w-[400px] bg-white rounded-md pt-7 px-14 gap-7 h-screen sticky top-10">

      <div className="mb-7">
	<Title order={3}>Price</Title>
	<RangeSlider minRange={10} min={10} max={5000} step={10} defaultValue={[10, 5000]} marks={[{ value: 10, label: '10' },{ value: 5000, label: '5000' },]}/>
      </div>
      <hr/>
      <div>
	<Title order={3}>Rating</Title>
	{
	  Array.from({length: 6}, (_, i) => (
	    <Checkbox defaultChecked key={i} label={<Stars rating={6-(i+1)} />} />
	  ))
	}
      </div>
      <hr/>
      <div>
	<Title order={3}>Availability</Title>
	<Checkbox label="Only show products in stock" />
      </div>

      <hr/>

      <Stack className="gap-0">
	<Title order={3}>Brand</Title>
	<Checkbox label="Apple" />
	<Checkbox label="Samsung" />
	<Checkbox label="Xiaomi" />
      </Stack>
    </Stack>
  )
}
