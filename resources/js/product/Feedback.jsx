/********************************
Developer: Mihail Vacarciuc
University ID: 230238428
********************************/
import React from 'react'
import { Stack, Flex,Title,Avatar, Text, Textarea, Button, Rating } from '@mantine/core'
import { Stars} from '../components/Stars'

export default function Feedback(){
  
  return (
    <Stack>
      <Title>Feedback</Title>
      <Flex>
	<Title order={3}>Overall rating</Title>
	<Stars rating={4} />
      </Flex>
      <LeaveFeedback/>
      <FeebackCard userName="John Doe" rating={4} comment={`
			    In metus vulputate eu scelerisque felis imperdiet proin fermentum leo vel orci porta non pulvinar neque. Quis eleifend quam adipiscing vitae proin sagittis, nisl rhoncus mattis rhoncus, urna neque viverra.
Enim, sed faucibus turpis in! Rutrum quisque non tellus orci, ac auctor augue mauris augue neque, gravida in fermentum et, sollicitudin ac orci phasellus egestas tellus rutrum tellus pellentesque eu?
Sed pulvinar proin gravida hendrerit! Elementum tempus egestas sed sed risus pretium quam vulputate dignissim suspendisse in est ante in nibh mauris, cursus mattis molestie a, iaculis at erat pellentesque.
Quam id leo in vitae turpis massa sed elementum tempus egestas sed sed risus pretium quam vulputate dignissim suspendisse in est ante? Feugiat pretium, nibh ipsum consequat nisl, vel pretium?
Lacus vel facilisis volutpat, est velit egestas dui, id ornare arcu? Ut etiam sit amet nisl purus, in mollis nunc sed id semper risus in hendrerit gravida rutrum quisque non?
Maecenas sed enim ut sem viverra aliquet eget sit amet tellus cras adipiscing enim eu turpis egestas pretium? In egestas erat imperdiet sed euismod nisi porta lorem mollis aliquam ut?
Vitae suscipit tellus mauris a diam maecenas sed enim ut sem viverra aliquet eget sit? Risus pretium quam vulputate dignissim suspendisse in est ante in nibh mauris, cursus mattis molestie.
Leo a diam sollicitudin tempor id. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus mauris vitae ultricies leo integer malesuada nunc vel risus commodo viverra maecenas accumsan.
Nibh cras pulvinar mattis nunc, sed blandit libero volutpat sed cras ornare arcu dui vivamus. Habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas sed tempus, urna!
Volutpat, est velit egestas dui, id? Risus ultricies tristique nulla aliquet enim tortor, at auctor urna nunc id cursus metus aliquam eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis!
Integer vitae justo eget magna fermentum? Sit amet purus gravida quis blandit turpis cursus in hac habitasse platea dictumst quisque sagittis, purus sit amet volutpat consequat, mauris nunc congue nisi?
Libero volutpat sed cras ornare arcu dui vivamus arcu felis, bibendum ut tristique et, egestas quis ipsum. Volutpat consequat, mauris nunc congue nisi, vitae suscipit tellus mauris a diam maecenas.
Auctor augue mauris augue neque, gravida in fermentum et, sollicitudin. Neque viverra justo, nec ultrices dui sapien eget mi proin sed libero enim, sed faucibus turpis in eu mi bibendum.
Ut placerat orci nulla pellentesque dignissim enim, sit amet venenatis urna cursus eget nunc scelerisque viverra. Velit dignissim sodales ut eu sem integer vitae justo eget magna fermentum iaculis eu.
Nisi porta lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor id eu nisl nunc mi ipsum, faucibus vitae aliquet! In egestas erat imperdiet sed euismod nisi porta lorem!
Enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu. Quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis.
Massa massa ultricies mi, quis hendrerit dolor magna. Vehicula ipsum a arcu cursus vitae congue mauris rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique senectus et.
Magna fringilla urna, porttitor rhoncus dolor purus non enim praesent elementum facilisis leo, vel fringilla est ullamcorper eget nulla facilisi etiam. Aliquet eget sit amet tellus cras adipiscing enim eu.
Non, consectetur a erat nam at lectus urna duis convallis convallis tellus, id interdum velit laoreet id! Aliquam vestibulum morbi blandit cursus risus, at ultrices mi tempus imperdiet nulla malesuada?
Euismod in pellentesque massa placerat duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper dignissim cras tincidunt. 
			     `} />
    </Stack>
  )

}

function FeebackCard({userName,rating,comment}){
  const [showMore,setShowMore] = React.useState(false)
  return (
    <Stack className="max-w-[800px] bg-white rounded-md pt-8 px-6">
      <Flex jusify="center" align="center" gap="50">
	<Flex gap="20" align="center">
	  <Avatar src="avatar.png" alt="it's me" size="xl" />
	  <Title order={2}>{userName}</Title>
	</Flex>
	<Stars rating={rating} />
      </Flex>
      <Text lineClamp={showMore ? 0 : 5}>{comment}</Text>
      <Text align="right" fs="italic" td="underline" className="cursor-pointer" onClick={() => setShowMore(!showMore)}>{showMore ? 'Show less' : 'Show more'}</Text>
    </Stack>
  )
}

function LeaveFeedback(){
  const [rating,setRating] = React.useState(0)
  return (
    <Stack className="max-w-[400px]">
      <Title order={2}>Leave your feedback</Title>
      <Stack gap="20">
	<Rating defaultValue={rating} onChange={setRating} size="xl" color="#FFE100" />
	<div contenteditable="true" className="bg-white rounded-md min-h-52 w-full focus:outline-none" >Please Leave you feedbakc here</div>
	<Button className="!rounded-md">Submit</Button>
      </Stack>
    </Stack>
  )
}
