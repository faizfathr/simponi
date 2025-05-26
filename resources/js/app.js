import './bootstrap';
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm'

window.Alpine = Alpine;
Alpine.plugin(persist);
Livewire.start();
Alpine.start()