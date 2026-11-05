@props(['dark'=>false])
<span class="inline-flex items-center gap-2.5">
 <svg width="38" height="38" viewBox="0 0 72 72" aria-hidden="true"><rect width="72" height="72" rx="16" fill="{{ $dark ? '#fff' : '#1E3A8A' }}"/><path d="M22 16H42Q54 16 54 27Q54 34 48 36Q56 38 56 47Q56 58 44 58H22Z" fill="{{ $dark ? '#1E3A8A' : '#fff' }}"/><path d="M31 24H40Q45 24 45 28Q45 32 40 32H31Z M31 40H42Q47 40 47 45Q47 50 42 50H31Z" fill="{{ $dark ? '#fff' : '#1E3A8A' }}"/><circle cx="62" cy="10" r="6" fill="#F97316"/></svg>
 <span class="text-xl font-medium {{ $dark ? 'text-white' : 'text-brand' }}">Bikrify</span>
</span>
