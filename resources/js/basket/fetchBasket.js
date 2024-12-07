export const fetchBasket = async () => {
    try {
      const req = await fetch('/api/basket', {headers: {'Accept': 'application/json',},})
      const res = await req.json();
      return res;
    }catch(e){
      console.log(e)
    }

  }
