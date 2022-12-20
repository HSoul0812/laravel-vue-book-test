import { mount } from '@vue/test-utils'
import BookModal from '../components/BookModal'

describe('Book Modal Test', () => {
  let wrapper

  beforeEach(()=>{
    wrapper = mount(BookModal)
  })
  
  test('renders properly', async () => {
    expect(wrapper.html()).toMatchSnapshot()
  })

})
