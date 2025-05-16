import './bootstrap';
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm'

Alpine.plugin(persist)
Livewire.start()