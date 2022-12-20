import { mount } from '@vue/test-utils'
import AuthorModal from '../components/AuthorModal'

describe('Author Modal Test', () => {
  let wrapper

  beforeEach(() => {
    wrapper = mount(AuthorModal)
  })

  test('renders properly', async () => {
    expect(wrapper.html()).toMatchSnapshot()
  })
})
