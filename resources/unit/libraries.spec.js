import { mount } from '@vue/test-utils'
import LibraryModal from '../components/LibraryModal'

describe('Library Modal Test', () => {
  let wrapper

  beforeEach(() => {
    wrapper = mount(LibraryModal)
  })

  test('renders properly', async () => {
    expect(wrapper.html()).toMatchSnapshot()
  })
})
