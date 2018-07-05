<?php

interface Traversable<out K = mixed, out V = mixed> {}

interface<K, V> IteratorAggregate<out It: Traversable<K, V> = Traversable>
	extends Traversable<K, V>
{
	function getIterator(): It;
}

interface Iterator<out K = mixed, out V = mixed>
	extends Traversable<K, V>
{
	function rewind(): void;
	function valid(): bool;
	function key(): K;
	function current(): V;
	function next(): void;
}

type iterable<K = mixed, V = mixed> =
		array<K, V>
	|	Iterator<K, V>
	|	IteratorAggregate<Traversable<K,V>>
;

interface ArrayAccess<in K = mixed, V = mixed>
{
	/* Nullable is correct here, I think. This leaves the choice whether
	 * to throw to the implementor. You can remove nullability in a return
	 * type; you cannot add it later. */
	function offestGet(K $offset): ?V;

	function offsetExists(K $offset): bool;
	function offsetSet(K $offset, V $value): void;
	function offsetUnset(K $offset): void;
}

/* todo: getInnerIterator() is currently documented as returning Iterator;
 * I expected Traversable similar to IteratorAggregate::getIterator(). */
interface<K, V> OuterIterator<out Inner: Iterator<K,V> = Iterator>
	extends Iterator<K, V>
{
	function getInnerIterator(): Inner;

	/* todo: default methods which implement all Iterator methods in terms
	 * of the Inner iterator would cut down on boilerplate for implementors.
	 */
}

/* todo: re-evaluate RecursiveIterator's design */
interface RecursiveIterator
	<	out K = mixed,
		out V = mixed,
		out Children: RecursiveIterator<K, V> = RecursiveIterator<K, V>
	>
	extends Iterator<K, V>
{
	function hasChildren(): bool;
	function getChildren(): Children;
}

// ----- New Interfaces
// Since they are new they do not contain default parameters.

interface BidirectionalIterator<out K, out V> extends Iterator<K,V>
{
	function end(): void;
	function prev(): void;
}

interface<K, V> ReversableAggregate<out It: Traversable<K, V>>
{
	function getReverseIterator(): It;
}


?>
