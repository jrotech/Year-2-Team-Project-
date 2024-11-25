//
// DO NOT USE THIS COMPONENT WITHOUT Mantineprovider && mantine ModalsProvider !!!
//

import React from 'react'
import { Stack, Flex, Button } from '@mantine/core'
import { modals } from '@mantine/modals';


export function Images({images,onSelect,selected}){
  const ref = React.useRef(null)
  return (
    <Stack  className="mr-11">
      
      <Button onClick={() => ref.current.scrollTop = ref.current.scrollTop - 200 } variant="transparent">
	<svg  xmlns="http://www.w3.org/2000/svg"  width="40"  height="40"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  strokeWidth="3"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-chevron-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
      </Button>
      <Stack className="overflow-hidden scroll-smooth" ref={ref}>
	{images.map((image, index) => (
	  <div className={`p-1 ${selected==image ? "border-main-accent" : "border-black"} border-2 w-36 rounded-md`} key={index} onClick={ () => onSelect(image)}>
	    <img key={index} alt={image.alt} src={image.src} />
	  </div>
	))}
      </Stack>
      <Button onClick={() => ref.current.scrollTop = ref.current.scrollTop + 200 } variant="transparent">
	<svg  xmlns="http://www.w3.org/2000/svg"  width="40"  height="40"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  strokeWidth="3"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
      </Button>
    </Stack>
  )
}

export function MainImage({src,alt}){
  const [opened,setOpened] = React.useState(false);

  return (
    <div className="w-[900px] max-h-[500px]" onClick={() => modals.open({
      centered: true,
      padding: "0",
      size: "70%",
      withCloseButton: false,
      children: (
	<img src={src} alt={alt} className="w-full" />
      )
    }) }>
      <img src={src} alt={alt} className="w-full max-h-[500px] z-[1000]" />
    </div>
  )
}


export default function Gallery({images}){
  const [mainImage, setMainImage] = React.useState(images[0])
  return (
    <Flex className="max-h-[500px]">
      <Images images={images} onSelect={setMainImage} selected={mainImage} />
      <MainImage src={mainImage.src} alt={mainImage.alt} />
    </Flex>
  )
}
